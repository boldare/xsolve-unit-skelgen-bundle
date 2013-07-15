<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

class LocateResult
{
    private $filename;
    private $qualifiedClassName;
    
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
