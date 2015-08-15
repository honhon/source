# -*- coding: utf-8 -*-
from ctrl import Ctrl
import urllib2
import hashlib
import base64
import logging
import sys

class CtrlEncode(Ctrl):
    def index(self):
        self.addJs("encode")
        return {}

    def query(self):
        act = self.request.get("act", "")
        request_text = self.request.get("request_text", "")
        char_set = self.request.get("char_set", "utf-8")
        try:
            response = ""
            if act == "url_enc":
                response = urllib2.quote(request_text.encode(char_set))
            elif act == "url_dec":
                logging.info(request_text)
                response = urllib2.unquote(request_text).encode('raw_unicode_escape').decode(char_set)
            elif act == "base64_enc":
                response = base64.b64encode(request_text.encode(char_set))
            elif act == "base64_dec":
                response = base64.b64decode(request_text).decode(char_set)
            elif act == "md5":
                response = hashlib.md5(request_text.encode(char_set)).hexdigest()
            elif act == "sha1":
                response = hashlib.sha1(request_text.encode(char_set)).hexdigest()
            logging.error(response)
            self.response.out.write(response)
        except Exception as e:
            logging.error(sys.exc_info())
            self.response.out.write(sys.exc_info())
            self.response.set_status(500)

        self.setView(None)
        return
