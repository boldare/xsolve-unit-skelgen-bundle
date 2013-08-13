<?php

namespace Xsolve\UnitSkelgenBundle\Runner;

use Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata;
use Xsolve\UnitSkelgenBundle\Utils\NameTools;

abstract class AbstractGenerationRunner
{
    /**
     * @var string $bin
     */
    protected $bin;

    /**
     * @var NameTools $nameTools
     */
    protected $nameTools;

    /**
     * @var string $bootstrapFile
     */
    protected $bootstrapFile;

    public function __construct($bin, NameTools $nameTools)
    {
        $this->bin = $bin;
        if (!$this->checkInstallation()) {
            throw new \InvalidArgumentException(
                'Please install/configure phpunit-skelgen binary'
            );
        }

        $this->nameTools = $nameTools;
        $this->bootstrapFile = $this->nameTools
            ->getRootDir() . '/bootstrap.php.cache';
    }

    public function run(LocationMetadata $locationMetadata)
    {
        $args = $this->createArgumentsMetadata($locationMetadata);
        $this->createTargetDir($args->getResultFilename());

        $cmd = sprintf(
            '%s --bootstrap %s --%s -- "%s" %s "%s" %s',
            $this->bin,
            $this->bootstrapFile,
            $args->getMode(),
            $args->getQualifiedClassName(),
            $args->getFilename(),
            $args->getResultQualifiedClassName(),
            $args->getResultFilename()
        );
        exec($cmd, $output, $returnValue);

        if ($returnValue > 0) {
            throw new \RuntimeException(
                'phpunit-skelgen for ' . $args->getQualifiedClassName() . ' failed with code ' . $returnValue
            );
        }

        return $args;
    }

    abstract protected function createArgumentsMetadata(LocationMetadata $locationMetadata);

    protected function checkInstallation()
    {
        if (!preg_match('/linux/i', PHP_OS)) {
            return true;
        }

        $path = shell_exec('which ' . $this->bin);
        if (strlen($path) > 0) {
            return true;
        } elseif (file_exists($this->bin)) {
            return true;
        }

        return false;
    }

    protected function createTargetDir($filename)
    {
        $dirname = dirname($filename);
        if (!is_dir($dirname)) {
            $result = mkdir($dirname, 0777, true);
            if (!$result) {
                throw new \RuntimeException(
                    'Cannot create target directory. Please check your permissions.'
                );
            }
        }
    }
}
