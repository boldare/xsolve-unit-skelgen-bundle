<?php

namespace Xsolve\UnitSkelgenBundle\Runner;

use Xsolve\UnitSkelgenBundle\Metadata\ArgumentsMetadata;
use Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata;

class ClassGenerationRunner extends AbstractGenerationRunner
{
    protected function createArgumentsMetadata(LocationMetadata $locationMetadata)
    {
        $resultFilename = $this->nameTools
            ->createProductionClassFilename($locationMetadata->getFilename());
        $resultQualifiedClassName = $this->nameTools
            ->createQualifiedClassName($resultFilename);
        
        $args = new ArgumentsMetadata('class', $locationMetadata);
        $args
            ->setResultFilename($resultFilename)
            ->setResultQualifiedClassName($resultQualifiedClassName);
        return $args;
    }   
}
