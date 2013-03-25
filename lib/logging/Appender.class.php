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
 * Appender allows you to log messags to any location.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package logging
 * @since   2.0
 */
class Appender
{

    /**
     * The layout to be used for this appender.
     *
     * @access private
     * @since  2.0
     * @type   Layout
     */
    var $layout;

    /**
     * Create a new Appender instance.
     *
     * @param Layout A Layout instance.
     *
     * @access public
     * @since  2.0
     */
    function Appender (&$layout)
    {

        $this->layout =& $layout;

    }

    /**
     * Cleanup appender resources if any exist.
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

    }

    /**
     * Retrieve the layout this appender is using.
     *
     * @return Layout A Layout instance.
     *
     * @access public
     * @since  2.0
     */
    function & getLayout ()
    {

        return $this->layout;

    }

    /**
     * Set the layout this appender will use.
     *
     * @param Layout A Layout instance.
     *
     * @access public
     * @since  2.0
     */
    function setLayout (&$layout)
    {

        $this->layout =& $layout;

    }

    /**
     * Write to this appender.
     *
     * <br/><br/>
     *
     * <note>
     *     This should never be called manually.
     * </note>
     *
     * @param message The message to write.
     *
     * @access public
     * @since  2.0
     */
    function write ($message)
    {

        $error = 'Appender::write($message) must be overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

}

?>
