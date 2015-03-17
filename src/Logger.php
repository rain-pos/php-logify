<?php
/**
 * Created by PhpStorm.
 * User: hhatfield
 * Date: 3/14/15
 * Time: 3:23 PM
 */

namespace DDM\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger{

    private static $instance = null;

    private $handlers = array(
        'emergency' => array(),
        'alert' => array(),
        'critical' => array(),
        'error' => array(),
        'warning' => array(),
        'notice' => array(),
        'info' => array(),
        'debug' => array(),
    );

    /**
     * Ensures use of the singleton pattern
     */
    protected function __construct(){

    }

    /**
     * Allows for resetting after tests.
     * Should not normally need to be called.
     */
    public function tearDown(){
        self::$instance = null;
    }

    /**
     * Method to get singleton of Logger
     *
     * @return Logger
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    /**
     * Add any PSR-3 Logger as a handler for a particular log level
     *
     * @param LoggerInterface $handler
     * @param $logLevel
     */
    public static function addHandler(LoggerInterface $handler, $logLevel){
        $logger = self::getInstance();
        $logger->handlers[$logLevel][]=$handler;
    }

    /**
     * Returns all handlers possibly filtered by log level
     *
     * @param null $logLevel
     * @return array
     */
    public function getHandlers($logLevel = null)
    {
        $handlers = $this->handlers;
        if($logLevel){
            $handlers = $this->handlers[$logLevel];
        }

        return $handlers;
    }

   /**
     * Runs all handlers associated with a given level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        foreach($this->handlers[$level] as $handler){
            $handler->log($level, $message, $context);
        }
    }
}