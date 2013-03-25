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
 * Do not validate or execute the action on any request method.
 *
 * <br/><br/>
 *
 * This is defined as 1.
 *
 * @since 1.0
 * @type  int
 */
define('REQ_NONE', 1);

/**
 * Validate and execute only on GET requests.
 *
 * <br/><br/>
 *
 * This is defined as 2.
 *
 * @since 1.0
 * @type  int
 */
define('REQ_GET',  2);

/**
 * Validate and execute only on POST requests.
 *
 * <br/><br/>
 *
 * This is defined as 4.
 *
 * @since 1.0
 * @type  int
 */
define('REQ_POST', 4);

/**
 * Request encapsulates a request into a class, which provides easy-to-manage
 * methods for directly accessing request information.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class Request
{

    /**
     * An associative array of attributes.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $attributes;

    /**
     * An associative array of errors.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $errors;

    /**
     * The request method used to make this request.
     *
     * @access private
     * @since  2.0
     * @type   int
     */
    var $method;

    /**
     * An associative array of user submitted parameters.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $params;

    /**
     * Create a new Request instance.
     *
     * @param array A parsed array of user submitted parameters.
     *
     * @access public
     * @since  1.0
     */
    function Request (&$params)
    {

        $this->attributes =  array();
        $this->errors     =  array();
        $this->method     = ($_SERVER['REQUEST_METHOD'] == 'POST')
                            ? REQ_POST : REQ_GET;
        $this->params     =& $params;

    }

    /**
     * Retrieve an attribute.
     *
     * @param string An attribute name.
     *
     * @return mixed An attribute value, if the given attribute exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & getAttribute ($name)
    {

        if (isset($this->attributes[$name]))
        {

            return $this->attributes[$name];

        }

	$null = NULL;
	return $null;
    }

    /**
     * Retrieve an indexed array of attribute names.
     *
     * @return array An array of attribute names.
     *
     * @access public
     * @since  1.0
     */
    function getAttributeNames ()
    {

        return array_keys($this->attributes);

    }

    /**
     * Retrieve an associative array of all attributes.
     *
     * @return array An array of attributes.
     *
     * @access public
     * @since  1.0
     */
    function & getAttributes ()
    {

        return $this->attributes;

    }

    /**
     * Retrieve a cookie.
     *
     * @param string A cookie name.
     *
     * @return string A cookie value, if the given cookie exists,
     *                otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getCookie ($name)
    {

        if (isset($_COOKIE[$name]))
        {

            return $_COOKIE[$name];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve an indexed array of cookie names.
     *
     * @return array An array of cookie names.
     *
     * @access public
     * @since  2.0
     */
    function getCookieNames ()
    {

        return array_keys($_COOKIE);

    }

    /**
     * Retrieve an associative array of cookies.
     *
     * @return array An array of cookies.
     *
     * @access public
     * @since  2.0
     */
    function & getCookies ()
    {

        return $_COOKIE;

    }

    /**
     * Retrieve an error message.
     *
     * @param string The name under which the message has been registered. If
     *               the error is validation related, it will be registered
     *               under a parameter name.
     *
     * @return string An error message, if a validation error has occured for
     *                the given parameter or was manually set by the developer,
     *                otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function getError ($name)
    {

        return (isset($this->errors[$name])) ? $this->errors[$name] : NULL;

    }

    /**
     * Retrieve an associative array of errors.
     *
     * @return array An array of errors, if any errors occured during validation
     *               or were manually set by the developer, otherwise
     *               <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & getErrors ()
    {

        return $this->errors;

    }

    /**
     * Retrieve the request method used for this request.
     *
     * @return int A request method that is one of the following:
     *
     *             <ul>
     *                 <li><b>REQ_GET</b> - serve GET requests</li>
     *                 <li><b>REQ_POST</b> - serve POST requests</li>
     *             </ul>
     *
     * @access public
     * @since  2.0
     */
    function getMethod ()
    {

        return $this->method;

    }

    /**
     * Retrieve a user submitted parameter.
     *
     * @param string A parameter name.
     * @param mixed  A default value.
     *
     * @return mixed A parameter value, if the given parameter exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & getParameter ($name, $value = 'NULL')
    {

        // the default $value value is the string value of NULL because
        // default values cannot be NULL itself

        if (isset($this->params[$name]))
        {

            return $this->params[$name];

        } else if ($value != 'NULL')
        {

            return $value;

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve an indexed array of user submitted parameter names.
     *
     * @return array An array of parameter names.
     *
     * @access public
     * @since  1.0
     */
    function getParameterNames ()
    {

        return array_keys($this->params);

    }

    /**
     * Retrieve an associative array of user submitted parameters.
     *
     * @return array An array of parameters.
     *
     * @access public
     * @since  1.0
     */
    function & getParameters ()
    {

        return $this->params;

    }

    /**
     * Determine if an attribute exists.
     *
     * @param string An attribute name.
     *
     * @return bool <b>TRUE</b>, if the given attribute exists, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function hasAttribute ($name)
    {

        return isset($this->attributes[$name]);

    }

    /**
     * Determine if a cookie exists.
     *
     * @param string A cookie name.
     *
     * @return bool <b>TRUE</b>, if the given cookie exists, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function hasCookie ($name)
    {

        return isset($_COOKIE[$name]);

    }

    /**
     * Determine if an error has been set.
     *
     * @param string The name under which the message has been registered. If
     *               the error is validation related, it will be registered
     *               under a parameter name.
     *
     * @return bool <b>TRUE</b>, if an error has been set for the given key,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function hasError ($name)
    {

        return isset($this->errors[$name]);

    }

    /**
     * Determine if any error has been set.
     *
     * @return bool <b>TRUE</b>, if any error has been set, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function hasErrors ()
    {

        return (sizeof($this->errors) > 0);

    }

    /**
     * Determine if the request has a parameter.
     *
     * @param string A parameter name.
     *
     * @return bool <b>TRUE</b>, if the given parameter exists, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function hasParameter ($name)
    {

        return isset($this->params[$name]);

    }

    /**
     * Remove an attribute.
     *
     * @param string An attribute name.
     *
     * @return mixed An attribute value, if the given attribute exists and has
     *               been removed, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & removeAttribute ($name)
    {

        if (isset($this->attributes[$name]))
        {

            $value =& $this->attributes[$name];

            unset($this->attributes[$name]);

            return $value;

        }

    }

    /**
     * Remove a parameter.
     *
     * @param string A parameter name.
     *
     * @return mixed A parameter value, if the given parameter exists and has
     *               been removed, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & removeParameter ($name)
    {

        if (isset($this->params[$name]))
        {

            $value =& $this->params[$name];

            unset($this->params[$name]);

            return $value;

        }

    }

    /**
     * Set an attribute.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     *
     * @access public
     * @since  1.0
     */
    function setAttribute ($name, $value)
    {

        $this->attributes[$name] =& $value;

    }

    /**
     * Set an attribute by reference.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     *
     * @access public
     * @since  1.0
     */
    function setAttributeByRef ($name, &$value)
    {

        $this->attributes[$name] =& $value;

    }

    /**
     * Set an error message.
     *
     * @param string The name under which the message will be registered.
     * @param string An error message.
     *
     * @access public
     * @since  1.0
     */
    function setError ($name, $message)
    {

        $this->errors[$name] =& $message;

    }

    /**
     * Set multiple error messages.
     *
     * @param array An associative array of error messages.
     *
     * @access public
     * @since  2.0
     */
    function setErrors ($errors)
    {

        $keys  = array_keys($errors);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->errors[$keys[$i]] = $errors[$keys[$i]];

        }

    }

    /**
     * Set the request method.
     *
     * @param int A request method that is one of the following:
     *
     *            <ul>
     *                <li><b>REQ_GET</b> - serve GET requests</li>
     *                <li><b>REQ_POST</b> - serve POST requests</li>
     *            </ul>
     *
     * @access public
     * @since  2.0
     */
    function setMethod ($method)
    {

        $this->method = $method;

    }

    /**
     * Manually set a parameter.
     *
     * @param string A parameter name.
     * @param mixed  A parameter value.
     *
     * @access public
     * @since  1.0
     */
    function setParameter ($name, $value)
    {

        $this->params[$name] = $value;

    }

    /**
     * Manually set a parameter by reference.
     *
     * @param string A parameter name.
     * @param mixed  A parameter value.
     *
     * @access public
     * @since  1.0
     */
    function setParameterByRef ($name, &$value)
    {

        $this->params[$name] =& $value;

    }

}

?>
