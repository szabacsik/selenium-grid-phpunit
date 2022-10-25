<?php
declare(strict_types=1);

namespace Tests\EndToEnd;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Helper\Registry;

/**
 * @testdox End-to-end test with Selenium Grid and PHPUnit
 */
class EndToEndTest extends TestCase
{
    /**
     * @testWith ["Selenium (software)"]
     * @testdox Open the landing page and check that the title is `$expected`
     */
    public function testOpenTheLandingPage(string $expected)
    {
        $driver = (Registry::getInstance())->get('driver');
        $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');
        $title = $driver->findElement(WebDriverBy::id('firstHeading'))->getText();
        $this->assertEquals($expected, $title);
    }

    /**
     * @testWith ["PHP"]
     * @testdox Search for `$expected` and check that the title changes to `$expected`
     */
    public function testSearchForPHP(string $expected)
    {
        $driver = (Registry::getInstance())->get('driver');
        $driver
            ->findElement(WebDriverBy::id('searchInput'))
            ->sendKeys($expected)
            ->submit();
        sleep(2);
        $title = $driver->findElement(WebDriverBy::id('firstHeading'))->getText();
        $this->assertEquals($expected, $title);
    }

    /**
     * @testWith ["This page was last edited on 24 October 2022, at 13:16 (UTC)."]
     * @testdox Check if the last edit date is `$expected`.
     */
    public function testLastEdited(string $expected)
    {
        $driver = (Registry::getInstance())->get('driver');
        $driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');
        $lastEdited = $driver->findElement(WebDriverBy::id('footer-info-lastmod'))->getText();
        $this->assertEquals($expected, $lastEdited);
    }

}