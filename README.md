# About

This bundle helps with PHPUnit test suites creation by using phpunit-skelgen (Skeleton Generator)

Features:

* feature 1
* feature 2
* feature 3

# Installation

1) Add to composer.json

    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:xsolve-pl/xsolve-unit-skelgen-bundle.git"
        }   
    ],
    "require": {
        "xsolve-pl/xsolve-unit-skelgen-bundle": "dev-master"
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
