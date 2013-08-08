<?php

namespace Xsolve\UnitSkelgenBundle\Metadata;

class LocationMetadata
{
    protected $filename;
    protected $qualifiedClassName;
    
    public function __construct($filename, $qualifiedClassName)
    {
        $this->filename = $filename;
        $this->qualifiedClassName = $qualifiedClassName;
    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function getQualifiedClassName()
    {
        return $this->qualifiedClassName;
    }
}
