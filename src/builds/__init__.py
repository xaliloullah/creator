from src.builds.templates import Template
from src.core import String
class Build:

    @staticmethod
    def creator():
        return Template("creator").render()
    
    @staticmethod
    def plu():
        pass

    @staticmethod
    def model(name: str, table: str, driver:str):
        if driver in ["file", "structure", ]:
            return Template("models.structure").render(name=name, table=table)
        return Template("models.model").render(name=name, table=table)
      
    @staticmethod
    def controller(name:str, model: str=None, resource: bool=False):
        render = ""
        if model:
            render += Template("controllers.model").render(model=String(model).snakecase(), Model=String(model).pascalcase())
        render += Template("controllers.controller").render(name=name)
        if resource:
            render += Template("controllers.resource").render()
        return render

    @staticmethod   
    def command(name: str):
        return Template("command").render(name=name)

    @staticmethod
    def migration(name: str):
        return Template("migration").render(name=name) 
    
    @staticmethod
    def seed(name: str):
        return Template("seed").render(name=name) 

    @staticmethod
    def test(name: str):
        return Template("test").render(name=name) 
    
    @staticmethod
    def middleware(name: str):
        return Template("middleware").render(name=name)  
        
    class Env:
        @staticmethod
        def app(**kwargs):
            name = kwargs.get("name", "creator")
            key = kwargs.get("key", False)
            lang = kwargs.get("lang", "en")
            mode = kwargs.get("mode", "console")
            host = kwargs.get("host", "127.0.0.1")
            port = kwargs.get("port", "5000")
            debug = kwargs.get("debug", False)
            return Template("env.app").render(name=name, key=key, lang=lang, host=host, port=port, mode=mode, debug=debug)

        @staticmethod
        def database(**kwargs):
            name = kwargs.get("name", "creator")
            path = kwargs.get("path", "databases")
            driver = kwargs.get("driver", "sqlite")

            render = Template("env.databases.database").render(path=path)
            if driver == "sqlite":
                render += Template("env.databases.sqlite").render(name=name)
            elif driver == "mysql":
                render += Template("env.databases.mysql").render(name=name, path=path, port="3306")
            elif driver == "postgresql":
                render += Template("env.databases.postgresql").render(name=name, path=path, port="5432")
            elif driver == "sqlserver":
                render += Template("env.databases.sqlserver").render(name=name, path=path, port="1433")
            return render

        @staticmethod
        def session(**kwargs):
            name = kwargs.get("name", "session")
            driver = kwargs.get("driver", "file")
            lifetime = kwargs.get("lifetime", 30)
            return Template("env.session").render(name=name, driver=driver, lifetime=lifetime)
        
    class View:
        @staticmethod
        def index(name=None):  
            return Template("views.resources.index").render(name=name)
        
        @staticmethod
        def create(name=None):   
            return Template("views.resources.create").render(name=name)
        @staticmethod
        def edit(name=None):  
            return Template("views.resources.edit").render(name=name) 
        @staticmethod
        def view(name=None):  
            return Template("views.resources.view").render(name=name)
           
        @staticmethod
        def default(name):
            return Template("views.default").render(name=name)
        
        @staticmethod
        def app(name):
            return Template("views.app").render(name=name)
        
        @staticmethod
        def main(name):
            return Template("views.main").render(name=name)
        
        @staticmethod
        def dashboard(name):
            return Template("views.dashboard").render(name=name)
        
        @classmethod
        def readme(**kwargs):
            name = kwargs.get("name") 
            logo = kwargs.get("logo") 
            description = kwargs.get("description") 
            # badges, project, description, features, installation, quickstart
            # """
    # Génère un README.md complet et élégant inspiré du README de Laravel.
    # - Supporte un logo centré, des badges (CI, PyPI, licence, downloads, couverture…),
    # - Sections About / Features / Docs / Tutorials / Sponsors / Contributing / Code of Conduct / Security / License,
    # - Utilisable via CLI ou fichier de config JSON.

    # Exemples:
    # python generate_readme.py --project "MyLib" --description "Une lib Python rapide et élégante." --logo-url "https://..." --license "MIT"
    # python generate_readme.py --config readme.config.json
    # """

    # from __future__ import annotations
    # import argparse
    # import json
    # from pathlib import Path
    # from typing import List, Dict, Any, Optional

    # # ------------ TEMPLATES UTILITAIRES ------------

    # def badge(label: str, image_url: str, link_url: Optional[str] = None) -> str:
    #     """Crée un badge markdown optionnellement cliquable."""
    #     img = f'![{label}]({image_url})'
    #     return f'[{img}]({link_url})' if link_url else img

    # def shields(label: str, image_path: str, link_url: Optional[str] = None) -> str:
    #     """Badges shields.io (image_path = ce qui suit https://img.shields.io/...)."""
    #     return badge(label, f'https://img.shields.io/{image_path}', link_url)

    # def gh_actions_badge(repo: str, workflow: str = "tests") -> str:
    #     """Badge GitHub Actions pour un repo public : owner/name."""
    #     img = f'https://github.com/{repo}/workflows/{workflow}/badge.svg'
    #     link = f'https://github.com/{repo}/actions'
    #     return badge("Build Status", img, link)

    # def pypi_badges(package: str) -> List[str]:
    #     """Badges PyPI utiles."""
    #     return [
    #         shields("PyPI - Version", f'pypi/v/{package}', f'https://pypi.org/project/{package}/'),
    #         shields("PyPI - Downloads", f'pypi/dm/{package}', f'https://pypi.org/project/{package}/'),
    #         shields("Python Versions", f'pypi/pyversions/{package}', f'https://pypi.org/project/{package}/'),
    #     ]

    # def license_badge(license_name: str, link_url: Optional[str] = None) -> str:
    #     """Badge licence."""
    #     link = link_url or "https://opensource.org/licenses"
    #     return shields("License", f'badge/license-{license_name.replace("-", "--")}-informational', link)

    # def coverage_badge(provider: str, image_url: str, link_url: str) -> str:
    #     """Badge de couverture perso (Codecov/Coveralls)."""
    #     return badge(provider, image_url, link_url)

    # # ------------ RENDU PRINCIPAL ------------

    # README_TEMPLATE = """<p align="center">{logo_html}</p>

    # <p align="center">
    # {badges_block}
    # </p>

    # ## About {project}

    # {description}

    # {features_block}

    # {installation_block}

    # {quickstart_block}

    # {docs_block}

    # {learning_block}

    # {sponsors_block}

    # ## Contributing

    # {contributing_text}

    # ## Code of Conduct

    # {coc_text}

    # ## Security Vulnerabilities

    # {security_text}

    # ## License

    # {license_text}
    # """

    # def render_list(title: str, items: List[str]) -> str:
    #     if not items:
    #         return ""
    #     bullet = "\n".join(f"- {it}" for it in items)
    #     return f"## {title}\n\n{bullet}\n"

    # def render_links_as_list(title: str, links: Dict[str, str]) -> str:
    #     if not links:
    #         return ""
    #     bullet = "\n".join(f"- [{name}]({url})." for name, url in links.items())
    #     return f"## {title}\n\n{bullet}\n"

    # def build_logo_html(logo_url: Optional[str], width: int = 400, alt: str = "Project Logo", href: Optional[str] = None) -> str:
    #     if not logo_url:
    #         return ""
    #     anchor_open = f'<a href="{href}" target="_blank">' if href else ""
    #     anchor_close = "</a>" if href else ""
    #     return f'{anchor_open}<img src="{logo_url}" width="{width}" alt="{alt}">{anchor_close}'

    # def build_badges(cfg: Dict[str, Any]) -> str:
    #     badges: List[str] = []

    #     # GitHub Actions
    #     if repo := cfg.get("github_repo"):
    #         wf = cfg.get("github_workflow", "tests")
    #         badges.append(gh_actions_badge(repo, wf))

    #     # PyPI
    #     if pkg := cfg.get("pypi_package"):
    #         badges.extend(pypi_badges(pkg))

    #     # Licence
    #     if lic := cfg.get("license"):
    #         badges.append(license_badge(lic, cfg.get("license_url")))

    #     # Couverture (optionnelle)
    #     if cov := cfg.get("coverage"):
    #         # coverage: {"label": "Codecov", "image_url": "...", "link_url": "..."}
    #         badges.append(coverage_badge(cov.get("label", "coverage"), cov["image_url"], cov.get("link_url", "")))

    #     # Badges custom
    #     for b in cfg.get("custom_badges", []):
    #         badges.append(badge(b.get("label", "badge"), b["image_url"], b.get("link_url")))

    #     return "\n".join(badges) if badges else ""

    # def render_readme(cfg: Dict[str, Any]) -> str:
    #     project = cfg.get("project", "YourProject")
    #     description = cfg.get("description", "A powerful and elegant application/library.")
    #     logo_html = build_logo_html(cfg.get("logo_url"), cfg.get("logo_width", 400), cfg.get("logo_alt", f"{project} Logo"), cfg.get("logo_href"))

    #     badges_block = build_badges(cfg)

    #     features_block = render_list("Features", cfg.get("features", []))

    #     installation_block = ""
    #     if install := cfg.get("installation"):
    #         installation_block = f"## Installation\n\n{install}\n"

    #     quickstart_block = ""
    #     if quick := cfg.get("quickstart"):
    #         quickstart_block = f"## Quick Start\n\n{quick}\n"

    #     docs_block = render_links_as_list("Documentation", cfg.get("documentation", {}))
    #     learning_block = render_links_as_list("Learning", cfg.get("learning", {}))

    #     sponsors_block = ""
    #     sponsors: Dict[str, str] = cfg.get("sponsors", {})
    #     if sponsors:
    #         bullets = "\n".join(f"- **[{name}]({url})**" for name, url in sponsors.items())
    #         sponsors_block = f"## Sponsors\n\nWe would like to extend our thanks to the following sponsors:\n\n{bullets}\n"

    #     contributing_text = cfg.get(
    #         "contributing_text",
    #         f"Thank you for considering contributing to {project}! Please check the contributing guide."
    #     )

    #     coc_text = cfg.get(
    #         "coc_text",
    #         "Please review and abide by the Code of Conduct to keep the community welcoming to all."
    #     )

    #     security_email = cfg.get("security_email", "security@example.com")
    #     security_text = cfg.get(
    #         "security_text",
    #         f"If you discover a security vulnerability, please email {security_email}. All vulnerabilities will be promptly addressed."
    #     )

    #     # Licence
    #     license_name = cfg.get("license", "MIT")
    #     license_url = cfg.get("license_url", "https://opensource.org/licenses/MIT" if license_name.upper() == "MIT" else "https://opensource.org/licenses")
    #     license_text = cfg.get(
    #         "license_text",
    #         f"{project} is open-sourced software licensed under the [{license_name} license]({license_url})."
    #     )

    #     return README_TEMPLATE.format(
    #         logo_html=logo_html,
    #         badges_block=badges_block,
    #         project=project,
    #         description=description,
    #         features_block=features_block,
    #         installation_block=installation_block,
    #         quickstart_block=quickstart_block,
    #         docs_block=docs_block,
    #         learning_block=learning_block,
    #         sponsors_block=sponsors_block,
    #         contributing_text=contributing_text,
    #         coc_text=coc_text,
    #         security_text=security_text,
    #         license_text=license_text,
    #     )

    # # ------------ CHARGEMENT & CLI ------------

    # def load_config(path: Path) -> Dict[str, Any]:
    #     with path.open("r", encoding="utf-8") as f:
    #         return json.load(f)

    # def save_readme(content: str, out_path: Path) -> None:
    #     out_path.write_text(content, encoding="utf-8")

    # def main():
    #     ap = argparse.ArgumentParser(description="Generate a complete README.md for your project.")
    #     ap.add_argument("--config", type=str, help="Path to JSON config file.")
    #     ap.add_argument("--project", type=str, help="Project name.")
    #     ap.add_argument("--description", type=str, help="Project short description.")
    #     ap.add_argument("--logo-url", type=str, help="Logo image URL.")
    #     ap.add_argument("--logo-href", type=str, help="Optional link when clicking the logo.")
    #     ap.add_argument("--logo-width", type=int, default=400, help="Logo width in px (default: 400).")
    #     ap.add_argument("--github-repo", type=str, help="GitHub repo like owner/name for Actions badge.")
    #     ap.add_argument("--github-workflow", type=str, default="tests", help="GitHub Actions workflow name (default: tests).")
    #     ap.add_argument("--pypi-package", type=str, help="PyPI package name for badges.")
    #     ap.add_argument("--license", type=str, default="MIT", help="License name (default: MIT).")
    #     ap.add_argument("--license-url", type=str, help="License URL.")
    #     ap.add_argument("--security-email", type=str, help="Security contact email.")
    #     ap.add_argument("--features", type=str, nargs="*", help="List of features (space-separated).")
    #     ap.add_argument("--installation", type=str, help="Markdown for Installation section.")
    #     ap.add_argument("--quickstart", type=str, help="Markdown for Quick Start section.")
    #     ap.add_argument("--out", type=str, default="README.md", help="Output path (default: README.md).")

    #     args = ap.parse_args()

    #     cfg: Dict[str, Any] = {}

    #     # 1) Via fichier de config si fourni
    #     if args.config:
    #         cfg = load_config(Path(args.config))

    #     # 2) Les arguments CLI écrasent la config
    #     for key, val in vars(args).items():
    #         if key in ("config", "out") or val is None:
    #             continue
    #         # Transformation camelCase attendue par cfg
    #         k = key.replace("_", "-")
    #         # Remet en snake pour nos accès .get, mais accepte les deux
    #         # On normalise en snake_keys
    #         snake_key = key
    #         cfg[snake_key] = val

    #     # Normaliser quelques alias (compat)
    #     if "logo-url" in cfg: cfg["logo_url"] = cfg["logo-url"]
    #     if "logo-href" in cfg: cfg["logo_href"] = cfg["logo-href"]
    #     if "logo-width" in cfg: cfg["logo_width"] = cfg["logo-width"]
    #     if "github-repo" in cfg: cfg["github_repo"] = cfg["github-repo"]
    #     if "github-workflow" in cfg: cfg["github_workflow"] = cfg["github-workflow"]
    #     if "pypi-package" in cfg: cfg["pypi_package"] = cfg["pypi-package"]

    #     content = render_readme(cfg)
    #     out_path = Path(args.out or "README.md")
    #     save_readme(content, out_path)
    #     print(f"✅ README generated at: {out_path.resolve()}")
            return Template('readme').render()
        
        