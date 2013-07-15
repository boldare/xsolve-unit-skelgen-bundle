<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            )
        ;
    }
        
    protected function processItem($item)
    {
        return $this->runner->executeTestGeneration($item);
    }
}
