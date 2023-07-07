# Behat traits

A collection of traits that help to quickly develop custom Context classes for
testing Drupal sites using Behat.

The following traits are included:

* `BrowserCapabilityDetectionTrait`: allows to detect whether a scenario is
  using a browser that supports JavaScript. This can be used to write step
  definitions that can interact both with JavaScript behaviors and non-JS
  fallbacks.
* `EntityTrait`: provides methods that allow to interact with entities using
  human readable names in step definitions, and translate them to machine names.
* `PageCacheTrait`: allows to write step definitions that are aware of whether
  the page that is currently loaded is cached or cacheable.

Each of these traits come with an example context that include some step
definitions to demonstrate how to use the traits.

## Requirements

This depends on the following software:

* [PHP 8.0](http://php.net/)
* [Drupal 9.4](https://www.drupal.org/)
* [Behat Drupal Extension](https://github.com/jhedstrom/drupalextension)

## Installation

Install the package and its dependencies. Since this is intended to be used for
testing, use the `--dev` option to install it as a development dependency:

```bash
$ composer require --dev drupaltest/behat-traits
```

## Usage

The project offers a number of traits that help to quickly create custom Behat
Context classes by performing common tasks that are typically needed in step
definitions for Drupal projects.

For some examples on how this can be used, see the test contexts in the
`./src/Context/` folder.

## Setting up a development environment

If you want to contribute to Behat Traits you can install a local development
environment for it by executing the following steps:

*Step 0: Clone the repository*

```bash
$ git clone https://github.com/drupaltest/behat-traits.git
$ cd behat-traits
```

### Using a local LAMP stack

*Step 1: Install dependencies*

```bash
$ composer install
```

*Step 2: Configure the environment*

Copy `runner.yml.dist` to `runner.yml` and change the configuration to match
your local environment. Typically you will need to specify `localhost` as your
database host, and change your base URL and database credentials.

*Step 3: Build*

```bash
$ ./vendor/bin/run drupal:site-setup
```

This will symlink the module in the proper directory within the test environment
and perform token substitution in test configuration files.

*Step 4: Install*

```bash
$ ./vendor/bin/run drupal:site-install
```

Your test site will be available at `./build`.

### Using Docker Compose

*Step 0: Download images*

```bash
$ docker-compose up -d
```

*Step 1: Install dependencies*

```bash
$ docker-compose exec web composer install
```

*Step 2: Configure the environment*

Copy `runner.yml.dist` to `runner.yml` and change the configuration to match
your local environment if needed. Usually this can be skipped since the module
ships with default configuration that matches the Docker environment.

*Step 3: Build*

```bash
$ docker-compose exec web ./vendor/bin/run drupal:site-setup
```

This will symlink the module in the proper directory within the test environment
and perform token substitution in test configuration files.

*Step 4: Install*

```bash
$ docker-compose exec web ./vendor/bin/run drupal:site-install
```

Your test site will be available at [http://localhost:8080/build](http://localhost:8080/build).

## Running tests

### Using a local LAMP stack

*Coding standards*

```bash
$ ./vendor/bin/grumphp run
```

*Behat tests*

```bash
$ ./vendor/bin/behat
```

### Using Docker Compose

*Coding standards*

```bash
$ docker-compose exec web ./vendor/bin/grumphp run
```

*Behat tests*

```bash
$ docker-compose exec web ./vendor/bin/behat
```
