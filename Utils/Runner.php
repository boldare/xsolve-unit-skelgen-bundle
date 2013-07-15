<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Runner
{
    private $container;
    
    /**
     * @var NameTools
     */
    private $nameTools;
    
    private $bootstrapFile;
    private $mode;
    private $resultQualifiedClassName;
    private $resultClassFilename;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->nameTools = $this->container->get('xsolve_unit_skelgen.name_tools');
        $this->bootstrapFile = $this->container->getParameter('kernel.root_dir') . '/bootstrap.php.cache';
    }
    
    public function executeTestGeneration(LocateResult $locateResult)
    {
        $this->mode = 'test';
        return $this->execute($locateResult);
    }
    
    public function executeClassGeneration(LocateResult $locateResult)
    {
        $this->mode = 'class';
        return $this->execute($locateResult);
    }
    
    protected function execute(LocateResult $locateResult)
    {
        $this->prepareResultNames($locateResult->getFilename());
        $this->createTargetDir();
        $cmd = sprintf(
            'phpunit-skelgen --bootstrap %s --%s -- "%s" %s "%s" %s',
            $this->bootstrapFile,
            $this->mode,
            $locateResult->getQualifiedClassName(),
            $locateResult->getFilename(),
            $this->resultQualifiedClassName,
            $this->resultClassFilename
        );
        exec($cmd);
        return '===> running: ' . $cmd . PHP_EOL;
    }
    
    protected function prepareResultNames($filename)
    {
        if ('test' === $this->mode) {
            $this->resultClassFilename = $this->nameTools->createTestFilename($filename);
        } else {
            $this->resultClassFilename = $this->nameTools->createProductionClassFilename($filename);
        }
        $this->resultQualifiedClassName = $this->nameTools->createQualifiedClassName($this->resultClassFilename);
    }
    
    protected function createTargetDir()
    {
        $dirname = dirname($this->resultClassFilename);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
    }
}
