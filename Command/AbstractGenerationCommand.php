<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xsolve\UnitSkelgenBundle\Utils\ClassLocator;
use Xsolve\UnitSkelgenBundle\Utils\Runner;

abstract class AbstractGenerationCommand extends ContainerAwareCommand
{
    /**
     * @var ClassLocator
     */
    protected $locator;
    
    /**
     * @var Runner
     */
    protected $runner;
    
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $namespace = $in->getArgument('namespace');
        $this->locator = $this->getContainer()->get('xsolve_unit_skelgen.class_locator');
        $this->runner = $this->getContainer()->get('xsolve_unit_skelgen.runner');
        
        $result = $this->locator->locate($namespace);
        foreach ($result as $item) {
            $output = $this->processItem($item);
            $out->writeln($output);
        }
    }
    
    protected abstract function processItem($item);
}