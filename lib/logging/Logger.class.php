<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the COPYRIGHT |
// | file that was distributed with this source code. If the COPYRIGHT file is |
// | missing, please visit the Mojavi homepage: http://www.mojavi.org          |
// +---------------------------------------------------------------------------+

/**
 * Debugging priority level.
 *
 * <br/><br/>
 *
 * This is defined as 1000.
 *
 * @since 2.0
 * @type  int
 */
define('LEVEL_DEBUG', 1000);

/**
 * Info priority level.
 *
 * <br/><br/>
 *
 * This is defined as 2000.
 *
 * @since 2.0
 * @type  int
 */
define('LEVEL_INFO', 2000);

/**
 * Error priority level.
 *
 * <br/><br/>
 *
 * This is defined as 4000.
 *
 * @since 2.0
 * @type  int
 */
define('LEVEL_ERROR', 4000);

/**
 * Warning priority level.
 *
 * <br/><br/>
 *
 * This is defined as 3000.
 *
 * @since 2.0
 * @type  int
 */
define('LEVEL_WARN', 3000);

/**
 * Fatal priority level.
 *
 * <br/><br/>
 *
 * This is defined as 5000.
 *
 * @since 2.0
 * @type  int
 */
define('LEVEL_FATAL', 5000);


/**
 * Logger provides an interface for logging messages to multiple appenders.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package logging
 * @since   2.0
 */
class Logger
{

    /**
     * An associative array of appenders.
     *
     * @access private
     * @since  2.0
     * @type   array
     */
    var $appenders;

    /**
     * The priority level that must be met or exceeded in order for Mojavi
     * to exit upon the logging of a message.
     *
     * @access private
     * @since  2.0
     * @type   int
     */
    var $exitPriority;

    /**
     * The priority level that must be met or exceeded in order for this logger
     * to log a message.
     *
     * @access private
     * @since  2.0
     * @type   int
     */
    var $priority;

    /**
     * Create a new Logger instance.
     *
     * @access public
     * @since  2.0
     */
    function Logger ()
    {

        // set default minimum priority levels
        $this->exitPriority = LEVEL_ERROR;
        $this->priority     = LEVEL_ERROR;

    }

    /**
     * Add an appender.
     *
     * <br/><br/>
     *
     * <note>
     *     If an appender with the given name already exists, an error will be
     *     reported.
     * </note>
     *
     * @param string   An appender name.
     * @param Appender An Appender instance.
     *
     * @access public
     * @since  2.0
     */
    function addAppender ($name, &$appender)
    {

        if (!isset($this->appenders[$name]))
        {

            $this->appenders[$name] =& $appender;
            return;

        }

        $error = 'Logger already has appender ' . $name;

        trigger_error($error, E_USER_ERROR);

        exit;

    }

    /**
     * Cleanup all appenders.
     *
     * <br/><br/>
     *
     * <note>
     *     This should never be called manually.
     * </note>
     *
     * @access public
     * @since  2.0
     */
    function cleanup ()
    {

        $keys  = array_keys($this->appenders);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->appenders[$keys[$i]]->cleanup();

        }

    }

    /**
     * Retrieve an appender.
     *
     * @param string An appender name.
     *
     * @return Appender An Appender instance, if the given appender exists,
     *                  otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getAppender ($name)
    {

        if (isset($this->appenders[$name]))
        {

            return $this->appenders[$name];

        }
	$null = NULL;
        return $null;

    }

    /**
     * Retrieve the priority level that must be met or exceeded in order for
     * Mojavi to exit upon the logging of a message.
     *
     * @return int A priority level.
     *
     * @access public
     * @since  2.0
     */
    function getExitPriority ()
    {

        return $this->exitPriority;

    }

    /**
     * Retrieve the priority level that must be met or exceeded in order for
     * this logger to log a message.
     *
     * @return int A priority level.
     *
     * @access public
     * @since  2.0
     */
    function getPriority ()
    {

        return $this->priority;

    }

    /**
     * Log a message.
     *
     * @param Message A Message instance.
     *
     * @access public
     * @since  2.0
     */
    function log (&$message)
    {

        // retrieve message priority
        $msgPriority =& $message->getParameter('p');

        if ($this->priority == 0 || $msgPriority >= $this->priority)
        {

            // loop through appenders and write to each one
            $keys  = array_keys($this->appenders);
            $count = sizeof($keys);

            for ($i = 0; $i < $count; $i++)
            {

                $appender =& $this->appenders[$keys[$i]];
                $layout   =& $appender->getLayout();
                $result   =& $layout->format($message);

                $appender->write($result);

            }

        }

        // should we exit?
        if ($this->exitPriority > 0 && $msgPriority >= $this->exitPriority)
        {

            // sayonara baby
            exit;

        }

    }

    /**
     * Remove an appender.
     *
     * @param string An appender name.
     *
     * @access public
     * @since  2.0
     */
    function removeAppender ($name)
    {

        if (isset($this->appenders[$name]))
        {

            $appender =& $this->appenders[$name];
            $appender->cleanup();

            unset($this->appenders[$name]);

        }

    }

    /**
     * Set the priority level that must be met or exceeded in order for Mojavi
     * to exit upon the logging of a message.
     *
     * <br/><br/>
     *
     * <note>
     *     A priority level of 0 will turn of exiting.
     * </note>
     *
     * @param int A priority level.
     *
     * @access public
     * @since  2.0
     */
    function setExitPriority ($priority)
    {

        $this->exitPriority = $priority;

    }

    /**
     * Set the priority level that must be met or exceeded in order for this
     * logger to log a message.
     *
     * <br/><br/>
     *
     * <note>
     *     A priority level of 0 will log any message.
     * </note>
     *
     * @param int A priority level.
     *
     * @access public
     * @since  2.0
     */
    function setPriority ($priority)
    {

        $this->priority = $priority;

    }

}

?>
