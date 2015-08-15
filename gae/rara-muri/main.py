#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# Copyright 2007 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
import os
import sys
import importlib
import logging
import webapp2
from google.appengine.ext.webapp import template

class MainHandler(webapp2.RequestHandler):
    def get(self, url_path):
        paths = url_path.split('/')
        first = paths.pop(0)
        second = "" if len(paths) == 0 else paths.pop(0)
        menu   = "top"   if first  == "" else first
        action = "index" if second == "" else second
        try:
            ctrl_class = "Ctrl" + menu.capitalize()
            ctrl_file  = "ctrl_" + menu
            sys.path.append("controllers")
            ctrl_module = importlib.import_module(ctrl_file)
            ctrl = getattr(ctrl_module, ctrl_class)(self.request, self.response, action)
            model = getattr(ctrl, action)()
            if ctrl.getTemplate() != None:
                model["js_list"] = ctrl.getJsList()
                view_path = os.path.join(os.path.dirname(__file__), 'views/' + ctrl.getTemplate())
                self.response.out.write(template.render(view_path, model))
        except:
            logging.error(sys.exc_info())
            view_path = os.path.join(os.path.dirname(__file__), 'views/error.html')
            self.response.out.write(template.render(view_path, {}))

    def post(self, url_path):
        self.get(url_path)

DEV = True if os.environ.get('SERVER_SOFTWARE', '').startswith('Development') else False
app = webapp2.WSGIApplication([
    ('/(.*)', MainHandler)
], debug=DEV)
