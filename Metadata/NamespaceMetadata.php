<?php

namespace Xsolve\UnitSkelgenBundle\Metadata;

class NamespaceMetadata
{
    protected $sourceDir;
    protected $namespace;
    protected $namespaceDir;
    protected $filename;
    
    function __construct($sourceDir, $namespace)
    {
        $this->sourceDir = $sourceDir;
        $this->namespace = $namespace;
        $this->namespaceDir = $sourceDir . '/' . str_replace('\\', '/', $namespace);
        $this->filename = $this->namespaceDir . '.php';
    }
    
    function getNamespace()
    {
        return $this->namespace;
    }
    
    function getNamespaceDir()
    {
        return $this->namespaceDir;
    }
    
    function getFilename()
    {
        return $this->filename;
    }
    
    function isFile()
    {
        return is_file($this->filename);
    }
}
