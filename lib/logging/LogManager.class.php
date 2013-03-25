<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the COPYRIGHT |
// | file that was distributed with this source code. If the COPYRIGHT file is |
// | missing, please visit the Mojavi homepage: http://www.mojavi.org          |
// +---------------------------------------------------------------------------+

// include dependencies
require_once(LOGGING_DIR . 'ErrorLogger.class.php');
require_once(LOGGING_DIR . 'PatternLayout.class.php');
require_once(LOGGING_DIR . 'StdoutAppender.class.php');

/**
 * LogManager manages all loggers.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package logging
 * @since   2.0
 */
class LogManager
{

    /**
     * An associative array of loggers.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $loggers;

    /**
     * Create a new LogManager instance.
     *
     * <br/><br/>
     *
     * <note>
     *     This should never be called manually.
     * </note>
     *
     * @access private
     * @since  2.0
     */
    function LogManager ()
    {

         $this->loggers = array();

         // create default logger
         $logger   =& new ErrorLogger();
         $layout   =& new PatternLayout('<b>%N</b> [%f:%l] %m%n');
         $appender =& new StdoutAppender($layout);

         $logger->addAppender('stdout', $appender);
         $this->loggers['default'] =& $logger;

    }

    /**
     * Add a logger.
     *
     * <br/><br/>
     *
     * <note>
     *     If a logger with the given name already exists, an error will be
     *     reported.
     * </note>
     *
     * @param string A logger name.
     * @param Logger A Logger instance.
     *
     * @access public
     * @since  2.0
     */
    function addLogger ($name, &$logger)
    {

        // get singleton instance and array of loggers
        $instance =& LogManager::getInstance();
        $loggers  =& $instance->getLoggers();

        if (!isset($loggers[$name]))
        {

            $loggers[$name] =& $logger;
            return;

        }

        $error = 'LogManager already contains logger ' . $name;

        trigger_error($error, E_USER_ERROR);

        exit;

    }

    /**
     * Cleanup all loggers.
     *
     * <br/><br/>
     *
     * <note>
     *     If a logger with the given name already exists, an error will be
     *     reported.
     * </note>
     *
     * @access public
     * @since  2.0
     */
    function cleanup ()
    {

        $keys  = array_keys($this->loggers);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->loggers[$keys[$i]]->cleanup();

        }

    }

    /**
     * Retrieve the default logger.
     *
     * @return Logger The default Logger instance.
     *
     * @access public
     * @since  2.0
     */
    function & getDefaultLogger ()
    {

        $logManager =& LogManager::getInstance();

        return $logManager->getLogger();

    }

    /**
     * Retrieve the single instance of LogManager.
     *
     * @return LogManager A LogManager instance.
     *
     * @access public
     * @since  2.0
     */
    function & getInstance ()
    {

        static $instance = NULL;

        if ($instance === NULL)
        {

            // can't use reference with static data
            $instance = new LogManager;

        }

        return $instance;

    }

    /**
     * Retrieve a logger.
     *
     * <br/><br/>
     *
     * <note>
     *     If a name is not specified, the default logger is returned.
     * </note>
     *
     * @param string A logger name.
     *
     * @return Logger A Logger instance, if the given Logger exists, otherwise
     *                <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getLogger ($name = 'default')
    {

        // get singleton instance and array of loggers
        $instance =& LogManager::getInstance();
        $loggers  =& $instance->getLoggers();

        if (isset($loggers[$name]))
        {

            return $loggers[$name];

        }
	$null = NULL;
        return $null;

    }

    /**
     * Retrieve an associative array of loggers.
     *
     * @return array An array of loggers.
     *
     * @access public
     * @since  2.0
     */
    function & getLoggers ()
    {

        return $this->loggers;

    }

    /**
     * Determine if a logger exists.
     *
     * @param string A logger name.
     *
     * @return bool <b>TRUE</b>, if the given logger exists, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function hasLogger ($name)
    {

        // get singleton instance and array of loggers
        $instance =& LogManager::getInstance();
        $loggers  =& $instance->getLoggers();

        return isset($loggers[$name]);

    }

    /**
     * Remove a logger.
     *
     * <br/><br/>
     *
     * <note>
     *     You cannot remove the default logger.
     * </note>
     *
     * @param string A logger name.
     *
     * @return Logger A Logger instance, if the given logger exists and has been
     *                removed, otherwise <b>NULL</b>.
     */
    function & removeLogger ($name)
    {

        // get singleton instance and array of loggers
        $instance =& LogManager::getInstance();
        $loggers  =& $instance->getLoggers();

        if ($name != 'default' && isset($loggers[$name]))
        {

            $logger =& $loggers[$name];

            unset($loggers[$name]);

            return $logger;

        }
	$null = NULL;
        return $null;

    }

}

?>
