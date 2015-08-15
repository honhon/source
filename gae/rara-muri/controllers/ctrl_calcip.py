# -*- coding: utf-8 -*-
from ctrl import Ctrl

class CtrlCalcip(Ctrl):
    def index(self):
        self.addJs("calcip")
        mask = []
        for i in range(30, 1, -1):
            mask.append(i)
        return {"mask": mask}
