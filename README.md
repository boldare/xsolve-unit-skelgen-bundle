# About

[![knpbundles.com](http://knpbundles.com/xsolve-pl/xsolve-unit-skelgen-bundle/badge)](http://knpbundles.com/xsolve-pl/xsolve-unit-skelgen-bundle)

This bundle helps with PHPUnit test suites creation by using phpunit-skelgen (Skeleton Generator)

Features:

* creates test suite class respectively to given namespace (for instance 
Controller/DemoController.php will have test in Test/Controller/DemoControllerTest.php)
* asterisks and dots pattern matching - it will create test suites for every matching class in found directory
* fully TDD capable - creates production classes based on test suite class
* easy to extend and introduce changes in the future

![Example usage](https://raw.github.com/xsolve-pl/xsolve-unit-skelgen-bundle/master/Resources/doc/xsolve-unit-skelgen-bundle-example.png)

# Installation

1) Add to composer.json

    "require": {
        "xsolve-pl/xsolve-unit-skelgen-bundle": "1.0.*"
    }

2) Install dependencies

    composer install

3) Enable the bundle in app/AppKernel.php

    public function registerBundles()
    {
        return array(
        // ...
            new Xsolve\UnitSkelgenBundle\XsolveUnitSkelgenBundle(),
        );
    }


# Usage

Generate PHPUnit test class for a single production class:

    app/console xsolve:skelgen:test Xsolve/ExampleBundle/Controller/DefaultController

Generate PHPUnit test class for a namespace:

    app/console xsolve:skelgen:test Xsolve/ExampleBundle/Controller/.

Nice matching! It will create tests for DefaultControllers in all the bundles:

    app/console xsolve:skelgen:test Xsolve/*/Controller/DefaultController

Using the same patterns you can generate production classes from test classes:

    app/console xsolve:skelgen:class Xsolve/ExampleBundle/Tests/Controller/DefaultControllerTest
