from ctrl import Ctrl
from google.appengine.api import memcache

class CtrlClear(Ctrl):
    def index(self):
        memcache.flush_all()
        return {}
