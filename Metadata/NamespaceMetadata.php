<?php

namespace Xsolve\UnitSkelgenBundle\Metadata;

class NamespaceMetadata
{
    protected $sourceDir;
    protected $namespace;
    protected $namespaceDir;
    protected $filename;

    public function __construct($sourceDir, $namespace)
    {
        $this->sourceDir = $sourceDir;
        $this->namespace = $namespace;
        $this->namespaceDir = $sourceDir . '/' . str_replace('\\', '/', $namespace);
        $this->filename = $this->namespaceDir . '.php';
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function getNamespaceDir()
    {
        return $this->namespaceDir;
    }

    public function getFilename()
    {
        return $this->filename;
    }
}
