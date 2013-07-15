<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

class TestRunner extends Runner
{
    protected function setMode()
    {
        $this->mode = 'test';
    }
    
    protected function prepareResultNames(LocateResult $locateResult)
    {
        
    }
}
