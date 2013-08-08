<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xsolve\UnitSkelgenBundle\Locator\ClassLocator;
use Xsolve\UnitSkelgenBundle\Runner\Runner;

abstract class AbstractGenerationCommand extends ContainerAwareCommand
{
    /**
     * @var ClassLocator $locator
     */
    protected $locator;
    
    /**
     * @var Runner $runner
     */
    protected $runner;
    
    public function execute(InputInterface $in, OutputInterface $out)
    {
        $this->locator = $this->getContainer()->get('xsolve_unit_skelgen.class_locator');
        var_dump($this->locator);
        $this->prepareRunner();
        var_dump($this->runner);
        
        $namespace = $in->getArgument('namespace');
        $result = $this->locator->locate($namespace);
        var_dump($result); die();
        foreach ($result as $item) {
            $this->runner->run($item);
        }
    }
    
    protected abstract function prepareRunner();
}
