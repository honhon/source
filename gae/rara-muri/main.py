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
#
import os
import json
import webapp2
import httplib
import urllib
import hashlib
from google.appengine.api import memcache
from google.appengine.ext.webapp import template
from xml.etree import ElementTree

class MainHandler(webapp2.RequestHandler):
    def get(self, param):
        render(self, "top", [])

class TwitterHandler(webapp2.RequestHandler):
    def get(self):
        render(self, "twitter", [])

class WordsHandler(webapp2.RequestHandler):
    def get(self, type="", word=""):
        word     = word.strip()
        contents = ""
        keywords = []
        indexes  = []

        indexes.append("あ,い,う,え,お,か,き,く,け,こ".split(","))
        indexes.append("さ,し,す,せ,そ,た,ち,つ,て,と".split(","))
        indexes.append("な,に,ぬ,ね,の,は,ひ,ふ,へ,ほ".split(","))
        indexes.append("ま,み,む,め,も,や,ゆ,よ".split(","))
        indexes.append("ら,り,る,れ,ろ,わ,を,ん".split(","))
        indexes.append("が,ぎ,ぐ,げ,ご,ざ,じ,ず,ぜ,ぞ".split(","))
        indexes.append("だ,ぢ,づ,で,ど,ば,び,ぶ,べ,ぼ".split(","))
        indexes.append("ぱ,ぴ,ぷ,ぺ,ぽ".split(","))
        indexes.append("a,b,c,d,e,f,g,h,i,j,k,l,m,n".split(","))
        indexes.append("o,p,q,r,s,t,u,v,w,x,y,z".split(","))
        try:
            mem_key = "list_" + hashlib.sha1(word).hexdigest()
            data = memcache.get(mem_key);
            if data is None:
                conn = httplib.HTTPConnection("www.bing.com")
                conn.request("GET", "/qsonhs.aspx?mkt=ja-JP&o=p&q=" + urllib.quote(word))
                res = conn.getresponse()
                data = res.read()
                conn.close()
                memcache.set(mem_key, data, 3600)
            j = json.loads(data)
            for item in j["AS"]["Results"][0]["Suggests"]:
                keywords.append(item["Txt"])

            if type == "detail" and word != "":
                contents = "Not found."

                mem_key = "detail_" + hashlib.sha1(word).hexdigest()
                data = memcache.get(mem_key);
                if data is None:
                    conn = httplib.HTTPConnection("ja.wikipedia.org")
                    conn.request("GET", "/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97/" + urllib.quote(word))
                    res = conn.getresponse()
                    data = res.read()
                    conn.close()
                    memcache.set(mem_key, data, 3600)
                tree = ElementTree.fromstring(data)
                contents = tree.find('.//{http://www.mediawiki.org/xml/export-0.8/}text').text
        except:
            pass

        render(self, "words", {"word":word, "indexes":indexes, "keywords":keywords, "contents":contents})

def render(self, tpl, params):
    path = os.path.join(os.path.dirname(__file__), 'views/' + tpl + '.html')
    self.response.out.write(template.render(path, params))

app = webapp2.WSGIApplication([
    ('/twitter/', TwitterHandler)
  , ('/words/', WordsHandler)
  , ('/words/(.*)/(.*)/', WordsHandler)
  , ('/(.*)', MainHandler)
], debug=True)
