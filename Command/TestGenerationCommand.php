<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestGenerationCommand extends Command
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
    
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $namespace = $in->getArgument('namespace');
        $out->writeln('You requested test generation for ' . $namespace . ' namespace');
    }
}
