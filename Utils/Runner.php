<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

abstract class Runner
{
    protected $mode = 'class';
    
    public function execute(LocateResult $locateResult)
    {
        $cmd = sprintf(
            'phpunit-skelgen --%s -- "%s" %s "%s" %s',
            $locateResult->getQualifiedClassName(),
            $locateResult->getFilename(),
            $this->getResultQualifiedClassName($locateResult),
            $this->getResultClassFilename($locateResult)
        );
        echo 'execute ' . $cmd . PHP_EOL;
    }
    
    protected abstract function getResultQualifiedClassName($locateResult);
    
    protected abstract function getResultClassFilename($locateResult);
    
}
