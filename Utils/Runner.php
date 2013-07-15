<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Runner
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function execute(LocateResult $locateResult)
    {
        $this->setMode();
        $this->prepareResultNames($locateResult);
        $cmd = sprintf(
            'phpunit-skelgen --%s -- "%s" %s "%s" %s',
            $this->mode,
            $locateResult->getQualifiedClassName(),
            $locateResult->getFilename(),
            $this->resultQualifiedClassName,
            $this->resultClassFilename
        );
        echo 'execute ' . $cmd . PHP_EOL;
    }
    
    protected abstract function setMode();
    
    protected abstract function prepareResultNames(LocateResult $locateResult);
    
}
