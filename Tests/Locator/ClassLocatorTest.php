<?php

namespace Xsolve\UnitSkelgenBundle\Tests\Locator;

use Mockery;
use Xsolve\UnitSkelgenBundle\Locator\ClassLocator;
use Xsolve\UnitSkelgenBundle\Utils\NameTools;

class ClassLocatorTest extends \PHPUnit_Framework_TestCase
{
    const FAKE_ROOT = '/project/root/app';
    const FAKE_SRC = '/project/root/src';

    /**
     * @var ClassLocator $classLocator
     */
    protected static $classLocator;

    /**
     * @var NameTools $nameTools
     */
    protected static $nameTools;

    public static function tearDownAfterClass()
    {
        Mockery::close();
    }

    public static function setUpBeforeClass()
    {
        $finderMock = Mockery::mock('Symfony\Component\Finder\Finder');
        $finderMock
            ->shouldReceive('files')
            ->times(2)
            ->andReturn($finderMock);
        $finderMock
            ->shouldReceive('followLinks')
            ->times(2)
            ->andReturn($finderMock);
        $finderMock
            ->shouldReceive('in')
            ->times(2)
            ->andReturn($finderMock);
        $finderMock
            ->shouldReceive('name')->with('*.php')
            ->times(2)
            ->andReturn(
                array(),
                array(
                    self::createFileMock(self::FAKE_SRC . '/Xsolve/ExampleBundle/Controller/SimpleController.php'),
                    self::createFileMock(self::FAKE_SRC . '/Xsolve/ExampleBundle/Controller/DefaultController.php'),
                    self::createFileMock(self::FAKE_SRC . '/Xsolve/ExampleBundle/Controller/OtherController.php')
                )
            );

        $pathToolsMock = Mockery::mock('Xsolve\UnitSkelgenBundle\Utils\PathTools');
        $pathToolsMock
            ->shouldReceive('normalize')
            ->times(2)
            ->andReturn(self::FAKE_ROOT, self::FAKE_SRC);
        $pathToolsMock
            ->shouldReceive('isFile')
            ->times(3)
            ->andReturn(false, true, false);

        self::$nameTools = new NameTools($pathToolsMock, self::FAKE_ROOT);
        self::$classLocator = new ClassLocator($finderMock, self::$nameTools, $pathToolsMock);
    }

    protected static function createFileMock($realpath)
    {
        $fileMock = Mockery::mock('\SplFileInfo');
        $fileMock
            ->shouldReceive('getRealPath')
            ->times(1)
            ->andReturn($realpath);

        return $fileMock;
    }

    public function testLocateEmpty()
    {
        $result = self::$classLocator->locate('Xsolve\ExampleBundle\NonExistant');
        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    public function testLocateSingle()
    {
        $result = self::$classLocator->locate('Xsolve\ExampleBundle\Simple');

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf('Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata', $result[0]);

        $this->assertEquals(
            $result[0]->getFilename(),
            self::FAKE_SRC . '/Xsolve/ExampleBundle/Simple.php'
        );
        $this->assertEquals(
            $result[0]->getQualifiedClassName(),
            'Xsolve\ExampleBundle\Simple'
        );
    }

    public function testLocateNamespace()
    {
        $result = self::$classLocator->locate('Xsolve\ExampleBundle\Controller\.');

        $this->assertInternalType('array', $result);
        $this->assertCount(3, $result);
        $this->assertInstanceOf('Xsolve\UnitSkelgenBundle\Metadata\LocationMetadata', $result[2]);

        $this->assertEquals(
            $result[1]->getFilename(),
            self::FAKE_SRC . '/Xsolve/ExampleBundle/Controller/DefaultController.php'
        );
        $this->assertEquals(
            $result[0]->getQualifiedClassName(),
            'Xsolve\ExampleBundle\Controller\SimpleController'
        );
    }
}
