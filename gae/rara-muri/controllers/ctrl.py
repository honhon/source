class Ctrl():
    def __init__(self, request, response, action):
        self.request  = request
        self.response = response
        self.action   = action
        self.view     = action
        self.js_list  = []

    def setView(self, view):
        self.view = view

    def addJs(self, js):
        self.js_list.append(js)

    def getJsList(self):
        return self.js_list

    def getTemplate(self):
        return self.__class__.__name__[4:].lower() + "_" + self.view + ".html" if self.view != None else None
