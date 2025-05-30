<?php

namespace App\Models\Bases;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bases\Color;
use App\Models\Bases\Statut;

class Module
{
    const DASHBOARD = 'dashboard';
    const DOCUMENTATIONS = 'documentations';

    const MANAGEMENT = 'management';
    const USERS = 'users';
    const TARIFS = 'tarifs';
    const ACCESS = 'access';

    const APP = 'app';
    const SERVICES = 'services';
    const CHATS = 'chats';
    const VCARD = 'vcards';
    const QRCODES = 'qrcodes';
    const RESUMES = 'resumes';
    const ARTICLES = 'articles';

    const COMMERCIALE = 'commerciale';
    const CLIENTS = 'clients';
    const FACTURES = 'factures';
    const DEVIS = 'devis';
    const CONTRATS = 'contrats';
    const EMAILS = 'emails';
    const FOURNISSEURS = 'fournisseurs';
    const CATEGORIES = 'categories';
    const PRODUITS = 'produits';

    const COMPTABILITE = 'comptabilite';
    const COMPTES = 'comptes';
    const JOURNAL = 'journal';
    const CAISSE = 'caisse';
    const PAIEMENTS = 'paiements';

    const RH = 'rh';
    const POSTES = 'postes'; // fonctions
    const EMPLOYES = 'employes';
    const POINTAGES = 'pointages';

    private string $value;
    private string $name;
    private string $color;
    private string $icon;
    private ?Statut $statut;
    private string $lock;
    private string $route;
    private string $link;
    private string $hidden;
    private string $target;
    private array $submodules;
    private static array $data = [];
    private string $description;
    private array $tags = [];


    private static array $attributes = [
        self::DASHBOARD => [
            'name' => 'Dashboard',
            'color' => Color::SECONDARY,
            'icon' => 'bi-speedometer2',
            'lock' => true,
            'route' => 'dashboard'
        ],
        self::MANAGEMENT => [
            'name' => 'Gestions',
            'color' => Color::SECONDARY,
            'icon' => 'bi-kanban',
            'link' => '#management',
            'lock' => true,
            'hidden' => true,
            'submodules' => [
                self::USERS => [
                    'name' => 'Utilisateurs',
                    'color' => Color::SECONDARY,
                    'icon' => 'bi-people',
                    'lock' => true,
                    'hidden' => true,
                    'route' => 'users.index'
                ],
                self::ACCESS => [
                    'name' => 'Permissions & Roles',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-shield-lock',
                    'lock' => true,
                    'hidden' => true,
                    'route' => 'access.index'
                ],
                self::TARIFS => [
                    'name' => 'Tarifs',
                    'color' => Color::PRIMARY,
                    'icon' => 'bi-ui-checks',
                    'lock' => true,
                    'hidden' => true,
                    'route' => 'tarifs.index'
                ]
            ]
        ],
        self::APP => [
            'name' => 'App',
            'color' => Color::INFO,
            'icon' => 'bi-grid',
            'link' => '#app',
            // 'lock' => true,
            'hidden' => true,
            'submodules' => [
                self::SERVICES => [
                    'name' => 'Services',
                    'color' => Color::WARNING,
                    'icon' => 'bi-briefcase',
                    'lock' => true,
                    'route' => 'services.index'
                ],
                self::CHATS => [
                    'name' => 'Chat',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-chat',
                    'lock' => true,
                    'route' => 'chats'
                ],
                self::RESUMES => [
                    'name' => 'Résumé (CV)',
                    'color' => Color::INFO,
                    'icon' => 'bi-file-person',
                    'lock' => true,
                    'route' => 'resumes.index'
                ],
                self::VCARD => [
                    'name' => 'VCard',
                    'color' => Color::WARNING,
                    'icon' => 'bi-person-vcard',
                    'lock' => true,
                    'route' => 'vcards.index'
                ],
                self::QRCODES => [
                    'name' => 'Qrcodes',
                    'color' => Color::DARK,
                    'icon' => 'bi-qr-code',
                    'lock' => true,
                    'route' => 'qrcodes.index'
                ],
                self::EMAILS => [
                    'name' => 'Email',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-envelope',
                    'lock' => true,
                    'route' => 'emails.index'
                ]
            ]
        ],
        self::COMMERCIALE => [
            'name' => 'Gestion Commerciale',
            'color' => Color::SECONDARY,
            'icon' => 'bi-shop',
            // 'lock' => true,
            'hidden' => true,
            'link' => '#commerciale',
            'submodules' => [
                self::CLIENTS => [
                    'name' => 'Clients',
                    'color' => Color::SECONDARY,
                    'icon' => 'bi-person',
                    'lock' => true,
                    'route' => 'clients.index'
                ],
                self::FACTURES => [
                    'name' => 'Factures',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-receipt',
                    'lock' => true,
                    'route' => 'factures.index'
                ],
                self::DEVIS => [
                    'name' => 'Devis',
                    'color' => Color::SECONDARY,
                    'icon' => 'bi-file-earmark-text',
                    'lock' => true,
                    'route' => 'devis.index'
                ],
                self::CONTRATS => [
                    'name' => 'Contrats',
                    'color' => Color::SECONDARY,
                    'icon' => 'bi-file-earmark',
                    'lock' => true,
                    'route' => 'contrats.index'
                ],
                self::ARTICLES => [
                    'name' => 'Gestion des Articles',
                    'color' => Color::WARNING,
                    'icon' => 'bi-cart3',
                    'lock' => true,
                    'link' => '#' . self::ARTICLES,
                    'submodules' => [
                        self::CATEGORIES => [
                            'name' => 'Catégories',
                            'color' => Color::WARNING,
                            'icon' => 'bi-box',
                            'lock' => true,
                            'route' => 'categories.index'
                        ],
                        self::PRODUITS => [
                            'name' => 'Produits',
                            'color' => Color::DANGER,
                            'icon' => 'bi-boxes',
                            'lock' => true,
                            'route' => 'produits.index'
                        ]
                    ]
                ],
                self::FOURNISSEURS => [
                    'name' => 'Fournisseurs',
                    'color' => Color::DARK,
                    'icon' => 'bi-person-check',
                    'lock' => true,
                    // 'route' => 'fournisseurs.index'
                ]
            ]
        ],
        self::COMPTABILITE => [
            'name' => 'Comptablité',
            'color' => Color::DANGER,
            'icon' => 'bi-bank',
            // 'lock' => true,
            'hidden' => true,
            'link' => '#' . self::COMPTABILITE,
            'submodules' => [
                self::COMPTES => [
                    'name' => 'Comptes',
                    'color' => Color::DANGER,
                    'icon' => 'bi-person-circle',
                    'lock' => true,
                ],
                self::JOURNAL => [
                    'name' => 'Journal',
                    'color' => Color::PRIMARY,
                    'icon' => 'bi-journals',
                    'route' => 'journals.index',
                    'lock' => true,
                ],
                self::CAISSE => [
                    'name' => 'Caisses',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-cash-coin',
                    'lock' => true,
                ],
                self::PAIEMENTS => [
                    'name' => 'Paiements',
                    'color' => Color::SUCCESS,
                    'icon' => 'bi-cash-stack',
                    'lock' => true,
                    'link' => '#'
                ]
            ]
        ],
        self::RH => [
            'name' => 'Ressource Humaine',
            'color' => Color::SUCCESS,
            'icon' => 'bi-person-workspace',
            // 'lock' => true, 
            'hidden' => true,
            'link' => '#rh',
            'submodules' => [
                self::POSTES => [
                    'name' => 'Postes',
                    'color' => Color::PRIMARY,
                    'icon' => 'bi-person-vcard-fill',
                    'lock' => true,
                    'statut' => 'new',
                    'route' => 'postes.index'
                ],
                self::EMPLOYES => [
                    'name' => 'Employes',
                    'color' => Color::INFO,
                    'icon' => 'bi-person-badge-fill',
                    'lock' => true,
                    'statut' => 'new',
                    'route' => 'employes.index'
                ],
                self::POINTAGES => [
                    'name' => 'Pointages',
                    'color' => Color::WARNING,
                    'icon' => 'bi-clock-fill',
                    'lock' => true,
                    'statut' => 'new',
                    'route' => 'pointages.index'
                ]
            ]
        ],
        self::DOCUMENTATIONS => [
            'name' => 'documentations',
            'color' => Color::SECONDARY,
            'icon' => 'bi-file-earmark-code-fill',
            'hidden' => true,
            'target' => '_blank',
            'route' => 'docs'
        ],
    ];

    public function __construct(string $module, array $attributes)
    {
        $this->value = $module;
        $this->name = $attributes['name'] ?? 'Module';
        $this->color = $attributes['color'] ?? Color::SECONDARY;
        $this->icon = $attributes['icon'] ?? 'bi-question-circle';
        $this->statut = $this->getStatutAttribute($attributes['statut'] ?? null);
        $this->lock = $attributes['lock'] ?? false;
        $this->route = $attributes['route'] ?? false;
        $this->link = $attributes['link'] ?? '#';
        $this->hidden = $attributes['hidden'] ?? false;
        $this->target = $attributes['target'] ?? '';
        $this->submodules = $this->getModules($attributes['submodules'] ?? []);
    }

    private function getModules(array $attributes): array
    {
        $data = [];
        foreach ($attributes as $module => $attributes) {
            $data[$module] = new self($module, $attributes);
        }
        return $data;
    }

    public static function initialize(array $modules = []): void
    {
        foreach (self::$attributes as $key => $attributes) {
            self::$data[$key] = new self($key, $attributes);
        }
    }

    public static function all(): array
    {
        return self::$data;
    }

    public function __get(string $property)
    {
        return $this->$property ?? null;
    }

    public static function filter(array $modules): array
    {
        return array_filter(self::$data, fn($key) => in_array($key, $modules), ARRAY_FILTER_USE_KEY);
    }

    public static function user(): array
    {
        return self::filter([self::DASHBOARD, self::APP, self::COMMERCIALE, self::COMPTABILITE]);
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'name' => $this->name,
            'color' => $this->color,
            'icon' => $this->icon,
            'statut' => $this->statut,
            'route' => $this->route,
            'link' => $this->link,
            'lock' => $this->lock,
            'hidden' => $this->hidden,
            'target' => $this->target,
            'submodules' => $this->submodules,
        ];
    }

    public function isLocked()
    {
        /** @var User $user */
        $user = Auth::user();
        return $this->lock && $user && $user->cannot($this->value);
    }

    public function isHidden()
    {
        /** @var User $user */
        $user = Auth::user();
        return $this->hidden && $user && $user->cannot($this->value);
    }

    public function isVisible()
    {
        return !$this->isHidden();
    }

    public static function flatten(array $modules = []): array
    {
        $modules = $modules ?? self::all();
        $data = [];

        foreach ($modules as $module) {
            $data[$module->value] = $module->name;
            if ($module->submodules) {
                $data += self::flatten($module->submodules);
            }
        }
        return $data;
    }

    public function getStatutAttribute($value = null)
    {
        if ($value) {
            return Statut::get($value);
        } else {
            return null;
        }
    }
}
