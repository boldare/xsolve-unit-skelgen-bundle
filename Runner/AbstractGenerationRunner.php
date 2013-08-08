<?php

namespace Xsolve\UnitSkelgenBundle\Runner;

use Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata;
use Xsolve\UnitSkelgenBundle\Utils\NameTools;

abstract class AbstractGenerationRunner
{
    /**
     * @var NameTools $nameTools
     */
    protected $nameTools;

    /**
     * @var string $bootstrapFile
     */
    protected $bootstrapFile;

    public function __construct(NameTools $nameTools)
    {
        $this->nameTools = $nameTools;
        $this->bootstrapFile = $this->nameTools
            ->getRootDir() . '/bootstrap.php.cache';
    }

    public function run(LocationMetadata $locationMetadata)
    {
        $args = $this->createArgumentsMetadata($locationMetadata);
        $this->createTargetDir($args->getResultFilename());

        $cmd = sprintf(
            'phpunit-skelgen --bootstrap %s --%s -- "%s" %s "%s" %s',
            $this->bootstrapFile,
            $args->getMode(),
            $args->getQualifiedClassName(),
            $args->getFilename(),
            $args->getResultQualifiedClassName(),
            $args->getResultFilename()
        );
        var_dump($cmd);
        //exec($cmd);
        return $args;
    }

    abstract protected function createArgumentsMetadata(LocationMetadata $locationMetadata);

    protected function createTargetDir($filename)
    {
        $dirname = dirname($filename);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }
    }
}
