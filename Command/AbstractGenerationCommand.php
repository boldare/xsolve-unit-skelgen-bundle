<?php

namespace Xsolve\UnitSkelgenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xsolve\UnitSkelgenBundle\Locator\ClassLocator;
use Xsolve\UnitSkelgenBundle\Metadata\ArgumentsMetadata;
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
            try {
                $argumentsMetadata = $this->runner->run($item);
                $this->writeSuccessLine($out, $argumentsMetadata);
            } catch (\RuntimeException $e) {
                $this->writeFailureLine($out, $e);
            }
        }
    }

    protected function writeSuccessLine(OutputInterface $out, ArgumentsMetadata $argumentsMetadata)
    {
        $out->write('[ <info>OK</info> ] ');
        $out->writeln($argumentsMetadata->getQualifiedClassName());
    }

    protected function writeFailureLine(OutputInterface $out, \RuntimeException $e)
    {
        $out->write('[ <error>FAIL</error> ] ');
        $out->writeln($e->getMessage());
    }

    abstract protected function prepareRunner();
}
