Contributing
============

This document contains guidelines for contributing to the Behat Traits project.

Coding standards
----------------

Since the main audience for this project is Drupal developers the project uses
the Drupal coding standards. Before submitting a pull request make sure to run
the coding standards checks and fix any violations:

```bash
$ ./vendor/bin/grumphp run
```

Test coverage
-------------

All methods in the traits should be covered by tests written in Behat. In order
to make this work it is recommended to provide step definitions with an example
implementation of how the traits are expected to be used. These step definitions
should be put in a Context class with the same name as the trait. The feature
containing the test scenario should also be given a name that resembles the 
trait being tested.

For examples see the `src/Context` and `tests/features` folders.
