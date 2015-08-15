# -*- coding: utf-8 -*-
from ctrl import Ctrl
import re
import sys
import json
import urllib2
import hashlib
import logging
from google.appengine.api import memcache
from google.appengine.api.urlfetch import fetch
from xml.etree import ElementTree

class CtrlWords(Ctrl):
    CACHE = True

    def index(self):
        word = ""
        indexes = self.getCharIndexes()
        keywords = self.getKeywords("")
        self.addJs("words")
        self.setView("index")
        return {"word":word, "indexes":indexes, "keywords":keywords, "contents":None}

    def search(self):
        paths = self.request.path.split("/")
        word = "" if len(paths) < 3 else urllib2.unquote(paths[3])
        indexes = self.getCharIndexes()
        keywords = self.getKeywords(word)
        self.addJs("words")
        self.setView("index")
        return {"word":word, "indexes":indexes, "keywords":keywords, "contents":None}

    def detail(self):
        paths = self.request.path.split("/")
        word = "" if len(paths) < 3 else urllib2.unquote(paths[3])
        indexes = self.getCharIndexes()
        keywords = self.getKeywords(word)
        contents = self.getContents(word)
        self.addJs("words")
        self.setView("index")
        return {"word":word, "indexes":indexes, "keywords":keywords, "contents":contents}

    def getKeywords(self, word):
        keywords = []
        try:
            mem_key = "words_list_" + hashlib.sha1(word).hexdigest()
            keywords = self.getMem(mem_key)
            if keywords is None:
                logging.debug("get keywords from bing api")
                keywords = self.getBingSuggestList(word)
                logging.error(keywords)
                self.setMem(mem_key, keywords)
        except:
            logging.error(sys.exc_info())
            raise
        return keywords

    def getContents(self, word):
        contents = None
        try:
            if word == "":
                return ""

            mem_key = "words_detail_" + hashlib.sha1(word).hexdigest()
            contents = self.getMem(mem_key)
            if contents is None:
                name    = ""
                caption = ""
                image   = ""
                url     = ""
                raku = self.getRakuten(word)
                if raku is not None:
                    name = raku["itemName"]
                    caption = raku["itemCaption"]
                    url = "http://hb.afl.rakuten.co.jp/hgc/042e6582.7b4c74ad.042e6583.3f3ff0e9/?pc=" + urllib2.quote(raku["itemUrl"]) + "&m=" + urllib2.quote(raku["itemUrl"])
#                   url   = raku["affiliateUrl"]
                    image = raku["mediumImageUrls"][0]["imageUrl"]
                data    = self.getWiki(word)
                contents = {"name": name, "caption": caption, "url": url, "image": image, "data": data}
                self.setMem(mem_key, contents)
        except:
            logging.error(sys.exc_info())
            raise
        return contents

    @staticmethod
    def getBingSuggestList(word):
        list = []
        try:
            res = fetch(url="http://www.bing.com/AS/Suggestions?cvid=0&mkt=ja-JP&qry=" + urllib2.quote(word), deadline=5)
            pattern = re.compile(r'query="(.+?)"')
            itr = pattern.finditer(res.content)
            for match in itr:
                list.append(match.group(1))
            """
            res = fetch(url="http://sg1.api.bing.com/qsonhs.aspx?mkt=ja-JP&o=p&q=" + urllib2.quote(word), deadline=5)
            j = json.loads(res.content)
            if j["AS"]["FullResults"] != 0:
                for item in j["AS"]["Results"][0]["Suggests"]:
                    list.append(item["Txt"])
            """
        except:
            logging.error(sys.exc_info())
        return list

    @staticmethod
    def getRakuten(word):
        data = None
        try:
            res = fetch(url="https://app.rakuten.co.jp/services/api/IchibaItem/Search/20130805?format=json&affiliateId=042e6582.7b4c74ad.042e6583.3f3ff0e9&hits=1&applicationId=d019e887005287225e7006eb6d0dd8b6&keyword=" + urllib2.quote(word), deadline=5)
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
            res = fetch(url="http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97/" + urllib2.quote(word), deadline=5)
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
