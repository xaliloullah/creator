class Audio:
    def __init__(self, audio: str):
        try:
            from just_playback import Playback
            self.audio = Playback(audio)
        except:
            Playback =None
        self.last_volume = 1.0

    def play(self):
        self.audio.play()

    def pause(self):
        self.audio.pause()

    def resume(self):
        self.audio.resume()

    def stop(self):
        self.audio.stop()

    def mute(self):
        self.audio.set_volume(0)

    def unmute(self):
        self.audio.set_volume(self.volume)

    def set_volume(self, volume: float):
        self.last_volume = max(0.0, min(1.0, volume))
        self.audio.set_volume(self.volume)

    def seek(self, position: float):
        self.audio.seek(position)
    
    def rewind(self): 
        self.seek(0)

    def forward(self, seconds: float = 5.0): 
        new_pos = self.curr_pos + seconds
        self.seek(new_pos)

    def backward(self, seconds: float = 5.0): 
        new_pos = self.curr_pos - seconds
        self.seek(new_pos)

    def loop(self, enable: bool = True):
        self.audio.loop_at_end(enable)

    def progress(self) -> float: 
        if self.duration > 0:
            return (self.curr_pos / self.duration) * 100
        return 0.0  

    def time_left(self) -> float: 
        return max(0.0, self.duration - self.curr_pos)

    def is_finished(self) -> bool: 
        return not self.playing and self.curr_pos >= self.duration

    def toggle_pause(self): 
        if self.playing:
            self.pause()
        elif self.paused:
            self.resume()

    def toggle_mute(self): 
        if self.volume > 0:
            self.mute()
        else:
            self.unmute()
    @property
    def playing(self) -> bool:
        return self.audio.playing

    @property
    def paused(self) -> bool:
        return self.audio.paused

    @property
    def duration(self) -> float:
        return self.audio.duration

    @property
    def curr_pos(self) -> float:
        return self.audio.curr_pos
    
    @property
    def volume(self) -> float: 
        return self.audio.volume