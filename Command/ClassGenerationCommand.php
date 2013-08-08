<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Component\Console\Input\InputArgument;

class ClassGenerationCommand extends AbstractGenerationCommand
{
    protected function configure()
    {
        $this
            ->setName('xsolve:skelgen:class')
            ->setDescription('Generate production classes for PHPUnit tests')
            ->addArgument(
                'namespace', InputArgument::REQUIRED,
                'Namespace to generate production classes for'
            );
    }
    
    protected function prepareRunner()
    {
        $this->runner = $this->getContainer()
            ->get('xsolve_unit_skelgen.class_gen_runner');
    }
}
