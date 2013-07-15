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
        $filename = $locateResult->getFilename();
        $matches = array();
        preg_match('/[^\/]Bundle\//', $filename, $matches);
        $lastMatch = end($matches);
        $filenameWithDir = str_replace($lastMatch, $lastMatch . 'Tests/', $filename);
        $this->resultClassFilename = preg_replace('/\.php$/i', 'Test.php', $filenameWithDir);
        
        $locator = $this->container->get('xsolve_unit_skelgen.class_locator');
        $sourceDir = $locator->getSourceDir();
        $filenameWithoutExt = preg_replace('/\.php$/', '', $filename);
        $filenameWithoutSrc = str_replace($sourceDir, '', $filenameWithoutExt);
        $taintedClassName = str_replace('/', '\\', $filenameWithoutSrc);
        $this->resultQualifiedClassName = preg_replace('/\\+/', '\\', $taintedClassName);
    }
}
