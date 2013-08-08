<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

use SplFileInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NameTools
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getRealPath($filename)
    {
        $fileInfo = new SplFileInfo($filename);
        return $fileInfo->getRealPath();
    }
    
    public function createQualifiedClassName($filename)
    {
        $filenameWithoutExt = preg_replace('/\.php$/', '', $filename);
        $filenameWithoutSrc = str_replace($this->getSourceDir(), '', $filenameWithoutExt);
        $taintedClassName = str_replace('/', '\\', $filenameWithoutSrc);
        $className = preg_replace('/\\+/', '\\', $taintedClassName);
        return preg_replace('/^\\\/', '', $className);
    }
    
    public function createTestFilename($filename)
    {
        $matches = array();
        preg_match('/[^\/]Bundle\//', $filename, $matches);
        $lastMatch = end($matches);
        $filenameWithTests = str_replace($lastMatch, $lastMatch . 'Tests/', $filename);
        return preg_replace('/\.php$/i', 'Test.php', $filenameWithTests);
    }
    
    public function createProductionClassFilename($filename)
    {
        $matches = array();
        preg_match('/\/Tests\//', $filename, $matches);
        $lastMatch = end($matches);
        $filenameWithoutTests = str_replace($lastMatch, '/', $filename);
        return preg_replace('/Test\.php$/i', '.php', $filenameWithoutTests);
    }
    
    public function getSourceDir()
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');
        return $this->getRealPath($rootDir . '/../src');
    }
}
