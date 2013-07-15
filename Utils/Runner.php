<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Runner
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->bootstrapFile = $this->container->getParameter('kernel.root_dir') . '/bootstrap.php.cache';
    }
    
    public function execute(LocateResult $locateResult)
    {
        $this->setMode();
        $this->prepareResultNames($locateResult);
        $cmd = sprintf(
            'phpunit-skelgen --bootstrap %s --%s -- "%s" %s "%s" %s',
            $this->bootstrapFile,
            $this->mode,
            $locateResult->getQualifiedClassName(),
            $locateResult->getFilename(),
            $this->resultQualifiedClassName,
            $this->resultClassFilename
        );
        $this->createTargetDir();
        echo 'execute ' . $cmd . PHP_EOL;
        exec($cmd);
    }
    
    protected function createTargetDir()
    {
        $dirname = dirname($this->resultClassFilename);
        var_dump($dirname);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
    }
    
    protected abstract function setMode();
    
    protected abstract function prepareResultNames(LocateResult $locateResult);
    
}
