<?php

namespace Xsolve\UnitSkelgenBundle\Runner;

use Xsolve\UnitSkelgenBundle\Metadata\ArgumentsMetadata;
use Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata;

class TestGenerationRunner extends AbstractGenerationRunner
{    
    protected function createArgumentsMetadata(LocationMetadata $locationMetadata)
    {
        $resultFilename = $this->nameTools
            ->createTestFilename($locationMetadata->getFilename());
        $resultQualifiedClassName = $this->nameTools
            ->createQualifiedClassName($resultFilename);
        
        $args = new ArgumentsMetadata('test', $locationMetadata);
        $args
            ->setResultFilename($resultFilename)
            ->setResultQualifiedClassName($resultQualifiedClassName);
        return $args;
    }
}
