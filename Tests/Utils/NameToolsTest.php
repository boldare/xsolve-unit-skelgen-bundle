<?php

namespace Xsolve\UnitSkelgenBundle\Tests\Utils;

use Xsolve\UnitSkelgenBundle\Utils\NameTools;

class NameToolsTest extends \PHPUnit_Framework_TestCase
{
    const FAKE_ROOT = '/project/root/app';
    const FAKE_SRC = '/project/root/src';

    protected $cases = array(
        // class directly inside bundle
        '/Xsolve/ExampleBundle/Simple.php' =>
        '/Xsolve/ExampleBundle/Tests/SimpleTest.php',

        // class inside subdirectory
        '/Xsolve/ExampleBundle/Controller/DefaultController.php' =>
        '/Xsolve/ExampleBundle/Tests/Controller/DefaultControllerTest.php',

        // double bundle in bundle name
        '/Xsolve/ExampleBundleBundle/Controller/DefaultController.php' =>
        '/Xsolve/ExampleBundleBundle/Tests/Controller/DefaultControllerTest.php',

        // alternative bundle directory format
        '/Xsolve/Bundle/ExampleBundle/Controller/DefaultController.php' =>
        '/Xsolve/Bundle/ExampleBundle/Tests/Controller/DefaultControllerTest.php',

        // assume directory containing Symfony has "XYZBundle" in its path
        '/ExampleBundle/Xsolve/ExampleBundle/DefaultController.php' =>
        '/ExampleBundle/Xsolve/ExampleBundle/Tests/DefaultControllerTest.php',

        // assume directory containing Symfony has "Tests" in its path
        '/Tests/Xsolve/ExampleBundle/Controller/DefaultController.php' =>
        '/Tests/Xsolve/ExampleBundle/Tests/Controller/DefaultControllerTest.php'
    );

    /**
     * @var NameTools $nameTools
     */
    protected $nameTools;

    public function setUp()
    {
        $normalizerMock = \Mockery::mock('Xsolve\UnitSkelgenBundle\Utils\Normalizer');
        $normalizerMock
            ->shouldReceive('normalize')
            ->times(2)
            ->andReturn(self::FAKE_ROOT, self::FAKE_SRC);

        $this->nameTools = new NameTools($normalizerMock, self::FAKE_ROOT);
    }

    public function testGetRootDir()
    {
        $this->assertEquals($this->nameTools->getRootDir(), self::FAKE_ROOT);
    }

    public function testGetSourceDir()
    {
        $this->assertEquals($this->nameTools->getSourceDir(), self::FAKE_SRC);
    }

    public function testCreateQualifiedProductionClassName()
    {
        $this->assertEquals(
            $this->nameTools->createQualifiedClassName(
                self::FAKE_SRC . '/Xsolve/ExampleBundle/Controller/DefaultController.php'
            ),
            'Xsolve\ExampleBundle\Controller\DefaultController'
        );
    }

    public function testCreateQualifiedTestClassName()
    {
        $this->assertEquals(
            $this->nameTools->createQualifiedClassName(
                self::FAKE_SRC . '/Xsolve/ExampleBundle/Tests/Controller/DefaultControllerTest.php'
            ),
            'Xsolve\ExampleBundle\Tests\Controller\DefaultControllerTest'
        );
    }

    public function testCreateTestFilename()
    {
        foreach ($this->cases as $input => $expected) {
            $this->assertEquals(
                $this->nameTools->createTestFilename(self::FAKE_SRC . $input),
                self::FAKE_SRC . $expected
            );
        }
    }

    public function testCreateProductionClassFilename()
    {
        foreach ($this->cases as $expected => $input) {
            $this->assertEquals(
                $this->nameTools->createProductionClassFilename(self::FAKE_SRC . $input),
                self::FAKE_SRC . $expected
            );
        }
    }
}
