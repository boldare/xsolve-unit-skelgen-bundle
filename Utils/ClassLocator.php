<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class ClassLocator
{
    private $container;
    
    /**
     * @var NameTools
     */
    private $nameTools;
    
    private $result = array();
    
    private $namespace;
    private $namespaceDir;
    private $filename;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->nameTools = $this->container->get('xsolve_unit_skelgen.name_tools');
    }
    
    public function locate($namespace)
    {
        $this->prepare($namespace);
        if (is_file($this->filename)) {
            return $this->getSingleResult();
        }
        $this->discover();
        return $this->result;
    }
    
    protected function prepare($namespace)
    {
        $this->namespace = $namespace;
        $namespaceDir = '/' . str_replace('\\', '/', $this->namespace);
        $this->namespaceDir = $this->nameTools->getSourceDir() . $namespaceDir;
        $this->filename = $this->namespaceDir . '.php';
    }
    
    protected function getSingleResult()
    {
        return array(
            $this->createResult($this->filename)
        );
    }
    
    protected function discover()
    {
        $finder = new Finder();
        $files = $finder
            ->files()
            ->in($this->namespaceDir)
            ->name('*.php');
        
        foreach ($files as $file) {
            $this->result[] = $this->createResult($file->getRealpath());
        }
    }
    
    protected function createResult($filename)
    {
        return new LocateResult(
            $filename,
            $this->nameTools->createQualifiedClassName($filename)
        );
    }
}
