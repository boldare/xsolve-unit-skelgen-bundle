<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestGenerationCommand extends ContainerAwareCommand
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
        $locator = $this->getContainer()->get('xsolve_unit_skelgen.class_locator');
        $runner = $this->getContainer()->get('xsolve_unit_skelgen.test_runner');
        
        $result = $locator->locate($namespace);
        foreach ($result as $item) {
            $runner->execute($item);
        }
    }
}
