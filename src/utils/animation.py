from typing import List, Any, Callable, Optional

class Animation:
    def __init__(self, frames: List[Any], speed: float = 1.0, loop: bool = True, delay: float = 0, reverse: bool = False):
        self.frames = frames
        self.speed = speed
        self.loop = loop
        self.delay = delay
        self.reverse = reverse

        self.index = 0
        self.current_frame = frames[self.index]
        self.total_frames = len(self.frames)

        # Callbacks
        self.on_start: Optional[Callable] = None
        self.on_update: Optional[Callable] = None
        self.on_pause: Optional[Callable] = None
        self.on_stop: Optional[Callable] = None

        # State
        self.running = False
        self.paused = False
        self.wait = 0.0
        self.tick = 0.0

    def start(self): 
        if self.reverse and len(self.frames) > 0:
            self.index = len(self.frames) - 1
            self.current_frame = self.frames[self.index]
        else:
            if len(self.frames) > 0:
                self.index = 0
                self.current_frame = self.frames[self.index]
        self.tick = 0.0
        self.wait = 0.0
        self.paused = False
        self.running = True
        self._call(self.on_start)  

    def pause(self): 
        self.paused = True
        self._call(self.on_pause)

    def resume(self):
        self.paused = False

    def stop(self):
        self.running = False
        self._call(self.on_stop)

    def reset(self): 
        self.index = (len(self.frames) - 1) if (self.reverse and len(self.frames) > 0) else 0
        self.current_frame = self.frames[self.index] if self.frames else None
        self.tick = 0.0
        self.wait = 0.0
        self.paused = False
        self.running = False

    def update(self, elapsed: float):
        if not self.running or self.paused: return
        if self.total_frames == 0: return 
        
        if self.loop and (self.index >= self.total_frames or self.index < 0):
            self.wait += elapsed
            if self.wait >= self.delay: 
                self.index = (self.total_frames - 1) if self.reverse else 0
                self.wait = 0.0
            else: return

        self.tick += elapsed
        while self.tick >= self.speed:
            self.tick -= self.speed 
            if not (0 <= self.index < self.total_frames):
                if self.loop: 
                    self.wait = 0.0
                    return
                else:
                    self.stop()
                    return 
            self.current_frame = self.frames[self.index]
            self._call(self.on_update)
            self.index += -1 if self.reverse else 1

    def _call(self, callback:Callable|None):
        try:
            if callback is not None:
                callback()
        except:
            pass


    def get_current_frame(self, index: Optional[int] = None) -> Any:
        if index is not None:
            return self.frames[index]
        return self.current_frame

