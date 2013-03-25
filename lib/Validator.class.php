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
 * Validator is a guaranteed way to make sure user submitted parameters are
 * valid. Validator can also modify values, providing a parameter filter system.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class Validator
{

    /**
     * The default error message for any occuring error.
     *
     * @access private
     * @since  2.0
     * @type   string
     */
    var $message;

    /**
     * An associative array of initialization parameters.
     *
     * @access protected
     * @since  2.0
     * @type   array
     */
    var $params;

    /**
     * Create a new Validator instance.
     *
     * @access public
     * @since  1.0
     */
    function Validator ()
    {

        $this->message = NULL;
        $this->params  = array();

    }

    /**
     * Execute the validator.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @param string     A parameter value.
     * @param string     An error message to be set, if an error occurs.
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return bool <b>TRUE</b>, if the validator completes successfully,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function execute (&$value, &$error, &$controller, &$request, &$user)
    {

        $error = 'Validator::execute(&$value, &$error, &$controller, ' .
                 '&$request, &$user) must be overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

    /**
     * Retrieve the default error message.
     *
     * <br/><br/>
     *
     * <note>
     *     This will return <b>NULL</b> unless an error message has been
     *     specified with <i>setErrorMessage()</i>.
     * </note>
     *
     * @return string An error message.
     *
     * @access public
     * @since  2.0
     */
    function getErrorMessage ()
    {

        return $this->message;

    }

    /**
     * Retrieve a parameter.
     *
     * @param string A parameter name.
     *
     * @return mixed A parameter value, if the given parameter exists, otherwise
     *               <b>NULL</b>.
     */
    function & getParameter ($name)
    {

        if (isset($this->params[$name]))
        {

            return $this->params[$name];

        }

        return NULL;

    }

    /**
     * Initialize the validator.
     *
     * @param array An associative array of initialization parameters.
     *
     * @access public
     * @since  1.0
     */
    function initialize ($params)
    {

        $this->params = array_merge($this->params, $params);

    }

    /**
     * Set the default error message for any occuring error.
     *
     * @return string An error message.
     *
     * @access public
     * @since  2.0
     */
    function setErrorMessage ($message)
    {

        $this->message = $message;

    }

    /**
     * Set a validator parameter.
     *
     * @param string A parameter name.
     * @param mixed  A parameter value.
     *
     * @access public
     * @since  2.0
     */
    function setParameter ($name, $value)
    {

        $this->params[$name] = $value;

    }

    /**
     * Set a validator parameter by reference.
     *
     * @param string A parameter name.
     * @param mixed  A parameter value.
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
