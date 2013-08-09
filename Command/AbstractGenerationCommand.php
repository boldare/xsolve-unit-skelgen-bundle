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
        $this->prepareRunner();

        $namespace = $in->getArgument('namespace');
        $result = $this->locator->locate($namespace);
        foreach ($result as $item) {
            $returnValue = $this->runner->run($item);
            $this->writeStatusLine($out, $returnValue, $item->getQualifiedClassName());
        }
    }

    protected function writeStatusLine(OutputInterface $out, $returnValue, $qualifiedClassName)
    {
        if ($returnValue > 0) {
            $out->write('[ <error>FAIL</error> ]');
        } else {
            $out->write('[ <info>OK</info> ]');
        }

        $out->writeln(' ' . $qualifiedClassName);
    }

    abstract protected function prepareRunner();
}
