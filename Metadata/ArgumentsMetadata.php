<?php

namespace Xsolve\UnitSkelgenBundle\Metadata;

class ArgumentsMetadata
{
    protected $mode;
    protected $qualifiedClassName;
    protected $filename;
    protected $resultQualifiedClassName;
    protected $resultFilename;
    
    public function __construct($mode, LocationMetadata $locationMetadata)
    {
        $this->mode = $mode;
        $this->qualifiedClassName = $locationMetadata->getQualifiedClassName();
        $this->filename = $locationMetadata->getFilename();
    }
    
    public function setResultQualifiedClassName($resultQualifiedClassName)
    {
        $this->resultQualifiedClassName = $resultQualifiedClassName;
        return $this;
    }
    
    public function setResultFilename($resultFilename)
    {
        $this->resultFilename = $resultFilename;
        return $this;
    }
    
    public function getMode()
    {
        return $this->mode;
    }
    
    public function getQualifiedClassName()
    {
        return $this->qualifiedClassName;

    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function getResultQualifiedClassName()
    {
        return $this->resultQualifiedClassName;
    }
    
    public function getResultFilename()
    {
        return $this->resultFilename;
    }
}
