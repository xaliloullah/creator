from typing import Any
try: 
    from PIL import Image as Img, ImageOps, ImageFilter, ImageEnhance, ImageDraw, ImageFont
except:
    pass
import io, base64

class Image:
    def __init__(self, path: str): 
        self.image = Img.open(path)
        self.path = path

    # === Affichage et infos ===
    def show(self): 
        self.image.show()

    def info(self): 
        return {
            "format": self.image.format,
            "mode": self.image.mode,
            "size": self.image.size,  # (width, height)
            "path": self.path,
        }

    # === Transformations ===
    def resize(self, width: int, height: int): 
        self.image = self.image.resize((width, height))
        return self

    def rotate(self, angle: float, expand=True): 
        self.image = self.image.rotate(angle, expand=expand)
        return self

    def crop(self, left: int, top: int, right: int, bottom: int): 
        self.image = self.image.crop((left, top, right, bottom))
        return self

    def convert(self, mode: str):
        # ex: 'L', 'RGB'
        self.image = self.image.convert(mode)
        return self

    # === Sauvegarde ===
    def save(self, path: str, format: str|Any = None): 
        self.image.save(path, format=format if format else self.image.format)
        return self
     
    # === Transformations avancées ===
    def flip_horizontal(self): 
        self.image = self.image.transpose(Img.FLIP_LEFT_RIGHT)  #type:ignore
        return self

    def flip_vertical(self):
        self.image = self.image.transpose(Img.FLIP_TOP_BOTTOM)  #type:ignore
        return self

    def thumbnail(self, max_size=(128, 128)):
        self.image.thumbnail(max_size)
        return self

    def fit(self, width, height): 
        self.image = ImageOps.fit(self.image, (width, height))
        return self

    # === Filtres ===
    def blur(self, radius=2):
        self.image = self.image.filter(ImageFilter.GaussianBlur(radius))
        return self

    def sharpen(self):
        self.image = self.image.filter(ImageFilter.SHARPEN)
        return self

    def grayscale(self):
        self.image = self.image.convert("L")
        return self

    def invert_colors(self):
        self.image = ImageOps.invert(self.image.convert("RGB"))
        return self

    # === Améliorations ===
    def enhance_brightness(self, factor: float):
        self.image = ImageEnhance.Brightness(self.image).enhance(factor)
        return self

    def enhance_contrast(self, factor: float):
        self.image = ImageEnhance.Contrast(self.image).enhance(factor)
        return self

    def enhance_color(self, factor: float):
        self.image = ImageEnhance.Color(self.image).enhance(factor)
        return self
     
    def add_border(self, size=10, color="black"):
        w, h = self.image.size
        new_img = Img.new("RGB", (w+2*size, h+2*size), color)
        new_img.paste(self.image, (size, size))
        self.image = new_img
        return self

    def draw_text(self, text, position=(10,10), color="white"):
        draw = ImageDraw.Draw(self.image)
        font = ImageFont.load_default()
        draw.text(position, text, font=font, fill=color)
        return self

    def to_base64(self, format="PNG"):
        buffer = io.BytesIO()
        self.image.save(buffer, format=format)
        return base64.b64encode(buffer.getvalue()).decode()

    @staticmethod
    def from_base64(data: str):
        buffer = io.BytesIO(base64.b64decode(data))
        return Image(Img.open(buffer))  #type:ignore
    