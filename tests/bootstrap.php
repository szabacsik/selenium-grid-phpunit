<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Helper\Registry;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use \Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Exception\WebDriverCurlException;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxOptions;

$serverUrl = 'http://127.0.0.1:4444'; //grid
//$serverUrl = 'http://127.0.0.1:9515'; //local chromedriver

$chromeOptions = (new ChromeOptions)->addArguments([
    '--disable-gpu',
    //'--headless',
    '--no-sandbox',
]);
$desiredCapabilities =
    DesiredCapabilities::chrome()
    ->setCapability(ChromeOptions::CAPABILITY, $chromeOptions)
    ->setCapability('acceptInsecureCerts', true);
/*
$firefoxOptions = (new FirefoxOptions())->addArguments([
    //'-headless'
]);
$desiredCapabilities =
    DesiredCapabilities::firefox()
        ->setCapability(FirefoxOptions::CAPABILITY, $firefoxOptions)
        ->setCapability('acceptInsecureCerts', true);
*/
$driver = null;
$attempts = 0;
const MAXIMUM_RETRY_ATTEMPTS = 10;
do {
    try {
        sleep(1);
        $driver = RemoteWebDriver::create($serverUrl, $desiredCapabilities);
    } catch (WebDriverCurlException $exception) {
        fwrite(STDOUT, (string)$exception . PHP_EOL);
        $attempts++;
        if ($attempts < MAXIMUM_RETRY_ATTEMPTS) {
            fwrite(STDOUT, "Retrying attempt $attempts of constructing the RemoteWebDriver.\n");
        }
        continue;
    }
    break;
} while ($attempts < MAXIMUM_RETRY_ATTEMPTS);
if (!$driver) {
    throw new RuntimeException('Construction of RemoteWebDriver failed.');
}

$registry = Registry::getInstance();
$registry->add('driver', $driver);
