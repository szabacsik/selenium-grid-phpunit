# End-to-End test with Selenium Grid and PHPUnit

This is a small experimental **End-to-End test automation** project. What I wanted to achieve was to be able to run **End-to-End** tests with **PHPUnit** by control Browsers from the test cases. It is possible with [Selenium Grid](https://github.com/SeleniumHQ/docker-selenium) and [PHP Webdriver](https://github.com/php-webdriver/php-webdriver). This would obviously be good if it could be easily run in the local development environment or from a CI/CD automated pipeline and could capture video of what happens in the browsers.

## Prerequisites

- PHP 8.1
- Composer
- Docker

## Run

```shell
composer test:endtoend
```
