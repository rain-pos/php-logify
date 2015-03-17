<?php
/**
 * Created by PhpStorm.
 * User: hhatfield
 * Date: 3/14/15
 * Time: 2:54 PM
 */

namespace DDM\Logger\Tests;

use DDM\Logger\Logger;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

class LoggerTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->logger = Logger::getInstance();
    }

    public function tearDown()
    {
        $this->logger->tearDown();
    }

    /** @test */
    public function should_add_handler()
    {
        //arrange
        $logger = $this->logger;

        $testHandler = new NullLogger();

        $expected = array($testHandler);

        //act
        $logger->addHandler($testHandler, LogLevel::INFO);

        //assert
        $actual = $logger->getHandlers(LogLevel::INFO);
        $this->assertEquals($expected, $actual, 'Should have received Null Logger');
    }

    /** @test */
    public function should_add_multiple_handlers_to_multiple_levels()
    {
        //arrange
        $logger = $this->logger;
        $testHandler = new NullLogger();

        $expected = array(
            LogLevel::EMERGENCY=>array(),
            LogLevel::ALERT=>array(),
            LogLevel::CRITICAL=>array(),
            LogLevel::ERROR=>array(),
            LogLevel::WARNING=>array(
                $testHandler
            ),
            LogLevel::NOTICE=>array(),
            LogLevel::INFO=>array(
                $testHandler,
                $testHandler
            ),
            LogLevel::DEBUG=>array(),
        );

        //act
        $logger->addHandler($testHandler, LogLevel::INFO);
        $logger->addHandler($testHandler, LogLevel::INFO);
        $logger->addHandler($testHandler, LogLevel::WARNING);

        //assert
        $actual = $logger->getHandlers();
        $this->assertEquals($expected, $actual, 'Should have received Null Logger');
    }

    /** @test */
    public function should_call_one_handler(){
        //arrange
        //act
        //assert
    }
}
