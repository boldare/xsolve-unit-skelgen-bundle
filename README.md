xsolve-unit-skelgen-bundle
==========================

Symfony2 Bundle for PHPUnit Skelgen Integration.

Generate PHPUnit test class for a single production class:
```app/console xsolve:skelgen:test Xsolve/ExampleBundle/Controller/DefaultController```

Generate PHPUnit test class for a namespace:
```app/console xsolve:skelgen:test Xsolve/ExampleBundle/Controller/.```

Nice matching! It will create tests for DefaultControllers in all the bundles:
```app/console xsolve:skelgen:test Xsolve/*/Controller/DefaultController```

Using the same patterns you can generate production classes from test classes:
```app/console xsolve:skelgen:class Xsolve/ExampleBundle/Tests/Controller/DefaultControllerTest```
