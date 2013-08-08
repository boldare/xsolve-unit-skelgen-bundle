<?php

namespace Xsolve\UnitSkelgenBundle\Locator;

use Symfony\Component\Finder\Finder;
use Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata;
use Xsolve\UnitSkelgenBundle\Metadata\NamespaceMetadata;
use Xsolve\UnitSkelgenBundle\Utils\NameTools;

class ClassLocator
{
    /**
     * @var Finder $finder
     */
    protected $finder;
    
    /**
     * @var NameTools $nameTools
     */
    protected $nameTools;
    
    public function __construct(Finder $finder, NameTools $nameTools)
    {
        $this->finder = $finder;
        $this->nameTools = $nameTools;
    }
    
    public function locate($namespace)
    {
        $namespaceMetadata = $this->createNamespaceMetadata($namespace);
        if ($namespaceMetadata->isFile()) {
            return $this->getSingleResult($namespaceMetadata);
        }
        
        return $this->getNamespaceResult($namespaceMetadata);
    }
    
    protected function getSingleResult(NamespaceMetadata $namespaceMetadata)
    {
        return array(
            $this->createResult($namespaceMetadata->getFilename())
        );
    }
    
    protected function getNamespaceResult(NamespaceMetadata $namespaceMetadata)
    {
        $files = $this->findFiles($namespaceMetadata);
        $result = array();
        foreach ($files as $file) {
            $result[] = $this->createLocationMetadata($file->getRealpath());
        }
        
        return $result;
    }
    
    protected function findFiles(NamespaceMetadata $namespaceMetadata)
    {
        return $this->finder
            ->files()
            ->followLinks()
            ->in($namespaceMetadata->getNamespaceDir())
            ->name('*.php');
    }
    
    protected function createNamespaceMetadata($namespace)
    {
        return new NamespaceMetadata(
            $this->nameTools->getSourceDir(),
            $namespace
        );
    }
    
    protected function createLocationMetadata($filename)
    {
        return new LocationMetadata(
            $filename,
            $this->nameTools->createQualifiedClassName($filename)
        );
    }
}
