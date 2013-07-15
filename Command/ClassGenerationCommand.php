<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClassGenerationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('xsolve:skelgen:class')
            ->setDescription('Generate production classes for PHPUnit tests')
            ->addArgument(
                'namespace', InputArgument::REQUIRED,
                'Namespace to generate production classes for'
            )
        ;
    }
    
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $namespace = $in->getArgument('namespace');
        $out->writeln('You requested production class generation for ' . $namespace . ' namespace');
    }
}
