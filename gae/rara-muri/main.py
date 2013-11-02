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
import sys
import logging
import json
import webapp2
import urllib
import hashlib
from google.appengine.api import memcache
from google.appengine.api.urlfetch import fetch
from google.appengine.ext.webapp import template
from xml.etree import ElementTree

class MainHandler(webapp2.RequestHandler):
    def get(self, param):
        render(self, "top", {})

class TwitterHandler(webapp2.RequestHandler):
    def get(self):
        render(self, "twitter", {})

class ClearHandler(webapp2.RequestHandler):
    def get(self):
        memcache.flush_all()
        self.response.headers['Content-Type'] = 'text/plain'
        self.response.out.write('Cleared !')

class WordsHandler(webapp2.RequestHandler):
    CACHE = True

    def get(self, type="", word=""):
        word     = word.strip()
        word1    = "" if word == "" else word.split()[0]
        contents = ""
        keywords = []
        indexes = self.getCharIndexes()
        try:
            mem_key = "list_" + hashlib.sha1(word).hexdigest()
            keywords = self.getMem(mem_key)
            if keywords is None:
                logging.debug("get keywords from bing api")
                keywords = self.getBingSuggestList(word)
                self.setMem(mem_key, keywords)

            if type == "detail" and word != "":
                mem_key = "detail_" + hashlib.sha1(word).hexdigest()
                contents = self.getMem(mem_key)
                if contents is None:
                    raku = self.getRakuten(word)
                    if raku is None and word != word1:
                        raku = self.getRakuten(word1)
                    name    = ""
                    caption = ""
                    image   = ""
                    url     = ""
                    if raku is not None:
                        name = raku["itemName"]
                        caption = raku["itemCaption"]
                        url = "http://hb.afl.rakuten.co.jp/hgc/042e6582.7b4c74ad.042e6583.3f3ff0e9/?pc=" + urllib.quote(raku["itemUrl"]) + "&m=" + urllib.quote(raku["itemUrl"])
#                       url   = raku["affiliateUrl"]
                        image = raku["mediumImageUrls"][0]["imageUrl"]
                    data    = self.getWiki(word1)
                    contents = {"name": name, "caption": caption, "url": url, "image": image, "data": data}
                    self.setMem(mem_key, contents)
        except:
            logging.error(sys.exc_info())

        render(self, "words", {"word":word, "indexes":indexes, "keywords":keywords, "contents":contents})

    @staticmethod
    def getBingSuggestList(word):
        list = []
        try:
            res = fetch(url="http://sg1.api.bing.com/qsonhs.aspx?mkt=ja-JP&o=p&q=" + urllib.quote(word), deadline=5)
            j = json.loads(res.content)
            if j["AS"]["FullResults"] != 0:
                for item in j["AS"]["Results"][0]["Suggests"]:
                    list.append(item["Txt"])
        except:
            logging.error(sys.exc_info())
        return list

    @staticmethod
    def getRakuten(word):
        data = None
        try:
            res = fetch(url="https://app.rakuten.co.jp/services/api/IchibaItem/Search/20130805?format=json&affiliateId=042e6582.7b4c74ad.042e6583.3f3ff0e9&hits=1&applicationId=d019e887005287225e7006eb6d0dd8b6&keyword=" + urllib.quote(word), deadline=5)
            j = json.loads(res.content)
            if j["count"] != 0:
                data = j["Items"][0]["Item"]
        except:
            logging.error(sys.exc_info())
        return data

    @staticmethod
    def getWiki(word):
        data = ""
        try:
            res = fetch(url="http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97/" + urllib.quote(word), deadline=5)
            body = res.content
            if body is not None and body != "":
                tree = ElementTree.fromstring(body)
                pickup = tree.find('.//{http://www.mediawiki.org/xml/export-0.8/}text')
                if pickup is not None:
                    data = pickup.text
        except:
            logging.error(sys.exc_info())
        return data

    @staticmethod
    def getCharIndexes():
        indexes = []
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
        return indexes

    def setMem(self, key, val):
        if self.CACHE == True:
            logging.debug("set mem: " + key)
            memcache.set(key, val, 3600)

    def getMem(self, key):
        if self.CACHE == True:
            logging.debug("get mem: " + key)
            mem = memcache.get(key)
            return None if mem == False else mem
        return None

def render(self, tpl, params):
    path = os.path.join(os.path.dirname(__file__), 'views/' + tpl + '.html')
    params.update({"os":os})
    self.response.out.write(template.render(path, params))

app = webapp2.WSGIApplication([
    ('/twitter/', TwitterHandler)
  , ('/words/', WordsHandler)
  , ('/words/(.*)/(.*)/', WordsHandler)
  , ('/clear/', ClearHandler)
  , ('/(.*)', MainHandler)
], debug=True)
