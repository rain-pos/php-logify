<?php
/**
 * Created by PhpStorm.
 * User: hhatfield
 * Date: 3/14/15
 * Time: 2:54 PM
 */

namespace RainPos\Logify\Tests;

use RainPos\Logify\Logger;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Mockery;

class LogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    protected $logger;

    public function setUp()
    {
        $this->logger = new Logger();
    }


    /** @test */
    public function itCallsOneHandler()
    {
        //arrange
        $nullMock = Mockery::mock('\Psr\Log\LoggerInterface');
        $this->logger->addHandler($nullMock, LogLevel::INFO);
        $nullMock->shouldReceive('log')->once();
        //act
        $this->logger->log(LogLevel::INFO, 'happiness');
        //assert
    }

    /** @test */
    public function itCallsOneHandlerMultipleLevels()
    {
        //arrange
        $nullMock = Mockery::mock('\Psr\Log\LoggerInterface');
        $this->logger->addHandler($nullMock, LogLevel::INFO);
        $this->logger->addHandler($nullMock, LogLevel::WARNING);
        $nullMock->shouldReceive('log')->once();
        //act
        $this->logger->log(LogLevel::INFO, 'happiness');
        $this->logger->log(LogLevel::WARNING, 'happiness');
        //assert
    }

}
