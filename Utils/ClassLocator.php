<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use SplFileInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class ClassLocator
{
    private $result = array();
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->rootDir = $this->container->getParameter('kernel.root_dir');
        $this->sourceDir = $this->getRealPath($this->rootDir . '/../src');
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
        $this->namespaceDir = $this->sourceDir . '/' . str_replace('\\', '/', $this->namespace);
        $this->filename = $this->namespaceDir . '.php';
    }
    
    public function getSourceDir()
    {
        return $this->sourceDir;
    }
    
    protected function getRealPath($filename)
    {
        $fileInfo = new SplFileInfo($filename);
        return $fileInfo->getRealPath();
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
        $filenameWithoutExt = preg_replace('/\.php$/', '', $filename);
        $filenameWithoutSrc = str_replace($this->sourceDir, '', $filenameWithoutExt);
        $taintedClassName = str_replace('/', '\\', $filenameWithoutSrc);
        $qualifiedClassName = preg_replace('/\\+/', '\\', $taintedClassName);
        return new LocateResult($filename, $qualifiedClassName);
    }
    
}
