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
 * Layout provides a customizable way to format data for an appender.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package logging
 * @since   2.0
 */
class Layout
{

    /**
     * Create a new Layout instance.
     *
     * @access public
     * @since  2.0
     */
    function Layout ()
    {

    }

    /**
     * Format a message.
     *
     * <br/><br/>
     *
     * <note>
     *     This should never be called manually.
     * </note>
     *
     * @param Message A Message instance.
     *
     * @access public
     * @since  2.0
     */
    function & format (&$message)
    {

        $error = 'Layout::format(&$message) must be overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

}

?>
