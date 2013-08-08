<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Component\Console\Input\InputArgument;

class TestGenerationCommand extends AbstractGenerationCommand
{
    protected function configure()
    {
        $this
            ->setName('xsolve:skelgen:test')
            ->setDescription('Generate PHPUnit tests for classes')
            ->addArgument(
                'namespace', InputArgument::REQUIRED,
                'Namespace to generate tests for'
            );
    }
    
    protected function prepareRunner()
    {
        $this->runner = $this->getContainer()
            ->get('xsolve_unit_skelgen.test_gen_runner');
    }
}
