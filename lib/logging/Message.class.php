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
 * Message contains information about a log message.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package logging
 * @since   2.0
 */
class Message
{

    /**
     * An associative array of message parameters.
     *
     * @access private
     * @since  2.0
     * @type   array
     */
    var $params;

    /**
     * Create a new Message instance.
     *
     * @param params An associative array of parameters.
     *
     * @access public
     * @since  2.0
     */
    function Message ($params = NULL)
    {

        $this->params = ($params == NULL) ? array() : $params;

    }

    /**
     * Retrieve a parameter.
     *
     * @param name A parameter name.
     *
     * @return string A parameter value, if a parameter with the given name
     *                exists, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getParameter ($name)
    {

        if (isset($this->params[$name]))
        {

            return $this->params[$name];

        }
	$null = NULL;
        return $null;

    }

    /**
     * Determine if a parameter was set.
     *
     * @param string A parameter name.
     *
     * @return bool <b>TRUE</b>, if the parameter has been set, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function hasParameter ($name)
    {

        return isset($this->params[$name]);

    }

    /**
     * Set a parameter.
     *
     * @param string A parameter name.
     * @param string A parameter value.
     *
     * @access public
     * @since  2.0
     */
    function setParameter ($name, $value)
    {

        $this->params[$name] = $value;

    }

    /**
     * Set a parameter by reference.
     *
     * @param string A parameter name.
     * @param string A parameter value.
     *
     * @access public
     * @since  2.0
     */
    function setParameterByRef ($name, &$value)
    {

        $this->params[$name] =& $value;

    }

}

?>
