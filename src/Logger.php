<?php
/**
 * Created by PhpStorm.
 * User: hhatfield
 * Date: 3/14/15
 * Time: 3:23 PM
 */

namespace RainPos\Logify;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger
{

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
     * constructor
     */
    public function __construct()
    {

    }

    /**
     * Add any PSR-3 Logger as a handler for a particular log level
     *
     * @param LoggerInterface $handler  handler to use
     * @param string|array          $logLevel level to use it on
     *
     * @return null
     */
    public function addHandler(LoggerInterface $handler, $userLogLevel)
    {
        if (!is_array($userLogLevel)) {
            $userLogLevel = array($userLogLevel);
        }
        foreach ($userLogLevel as $logLevelString) {
            $logLevel = $this->getLevel($logLevelString);
            $this->handlers[$logLevel][] = $handler;
        }
    }
    
    /**
     * Remove all handlers         
     *
     * @return null
     */
    public function removeHandlers()
    {
        $this->handlers = array(
            'emergency' => array(),
            'alert' => array(),
            'critical' => array(),
            'error' => array(),
            'warning' => array(),
            'notice' => array(),
            'info' => array(),
            'debug' => array(),
        );
    }

    /**
     * @param $levelString string to be checked;
     * @return mixed
     */
    protected function getLevel($levelString)
    {
        $levelToCheck = '\Psr\Log\LogLevel::' . strtoupper($levelString);
        if (defined($levelToCheck)) {
            return constant($levelToCheck);
        }
        throw new InvalidArgumentException(
            'PSR-3 LogLevel required. ' . $levelString . ' given'
        );
    }
    /**
     * Returns all handlers possibly filtered by log level
     *
     * @param null $logLevel
     *
     * @return array
     */
    public function getHandlers($logLevel = null)
    {
        $handlers = $this->handlers;
        if ($logLevel) {
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
        foreach ($this->handlers[$level] as $handler) {
            $handler->log($level, $message, $context);
        }
    }
}
