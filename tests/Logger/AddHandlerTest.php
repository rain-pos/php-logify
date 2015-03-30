<?php
/**
 * Created by PhpStorm.
 * User: hhatfield
 * Date: 3/23/15
 * Time: 10:22 PM
 */

namespace DDM\Logify\Tests;

use DDM\Logify\Logger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\NullLogger;
use Psr\Log\LogLevel;

class AddHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    protected $logger;

    public function setUp()
    {
        $this->logger = new Logger();
    }

    /**
     * @test
     */
    public function canAddToValidLevel()
    {

        $this->logger->addHandler(new NullLogger(), LogLevel::INFO);

        $this->assertEquals(
            array(new NullLogger()),
            $this->logger->getHandlers(LogLevel::INFO),
            'Should have received Null Logger'
        );

    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function cannotAddToInvalidLevel()
    {
        $this->logger->addHandler(new NullLogger(), 'invalid');
    }

    /** @test */
    public function canAddToMultipleLevels()
    {
        $levels = array(
            LogLevel::ALERT,
            LogLevel::INFO
        );

        $logger = new NullLogger();
        $this->logger->addHandler($logger, $levels);
        $this->assertSame(
            array($logger),
            $this->logger->getHandlers(LogLevel::ALERT),
            'Should have been added to Alert level'
        );
        $this->assertSame(
            array($logger),
            $this->logger->getHandlers(LogLevel::INFO),
            'Should have been added to Info level'
        );
    }

    /** @test */
    public function canAddsMultipleHandlersToOneLevel()
    {
        //arrange
        $testHandler = new NullLogger();

        $expected = array(
            LogLevel::EMERGENCY=>array(),
            LogLevel::ALERT=>array(),
            LogLevel::CRITICAL=>array(),
            LogLevel::ERROR=>array(),
            LogLevel::WARNING=>array(),
            LogLevel::NOTICE=>array(),
            LogLevel::INFO=>array(
                $testHandler,
                $testHandler
            ),
            LogLevel::DEBUG=>array(),
        );

        //act
        $this->logger->addHandler($testHandler, LogLevel::INFO);
        $this->logger->addHandler($testHandler, LogLevel::INFO);

        //assert
        $this->assertEquals(
            $expected,
            $this->logger->getHandlers(),
            'Should have received Null Logger'
        );
    }
}
