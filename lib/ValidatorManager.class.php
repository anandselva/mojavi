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
 * ValidatorManager automates the parameter validation process.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class ValidatorManager
{

    /**
     * An associative array of parameter validators.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $validators;

    /**
     * Create a new ValidatorManager instance.
     *
     * @access public
     * @since  1.0
     */
    function ValidatorManager ()
    {

        $this->validators = array();

    }

    /**
     * Execute all validators.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @access public
     * @since  1.0
     */
    function execute (&$controller, &$request, &$user)
    {

        $keys    = array_keys($this->validators);
        $count   = sizeof($keys);
        $success = TRUE;

        for ($i = 0; $i < $count; $i++)
        {

            $param    =  $keys[$i];
            $value    =& $request->getParameter($param);
            $required =  $this->validators[$param]['required'];

            if (!$required && ($value == NULL || (is_string($value) && strlen($value) == 0)))
            {

                // bypass validation since this isn't required

            } else if ($value == NULL || (is_string($value) && strlen($value) == 0) || (is_array($value) && count($value)))
            {

                // param is required but doesn't exist
                $message = $this->validators[$param]['message'];

                $request->setError($param, $message);

                $success = FALSE;

            } else if (isset($this->validators[$param]['validators']))
            {

                // loop through each validator for this parameter
                $error    = NULL;
                $subCount = sizeof($this->validators[$param]['validators']);

                for ($x = 0; $x < $subCount; $x++)
                {

                    $validator =& $this->validators[$param]['validators'][$x];

                    if (!$validator->execute($value, $error, $controller,
                                             $request, $user))
                    {

                        if ($validator->getErrorMessage() == NULL)
                        {

                            $request->setError($param, $error);

                        } else
                        {

                            $request->setError($param,
                                               $validator->getErrorMessage());

                        }

                        $success = FALSE;

                        break;

                    }

                }

            }

        }

        return $success;

    }

    /**
     * Register a validator.
     *
     * @param string    A parameter name to be validated.
     * @param Validator A Validator instance.
     *
     * @access public
     * @since  1.0
     */
    function register ($param, &$validator)
    {

        if (!isset($this->validators[$param]))
        {

            $this->validators[$param] = array();

        }

        if (!isset($this->validators[$param]['validators']))
        {

            $this->validators[$param]['validators'] = array();

        }

        // add this validator to the list for this parameter
        $this->validators[$param]['validators'][] =& $validator;

        // specify that this parameter is required, if a required status
        // has not yet been specified
        if (!isset($this->validators[$param]['required']))
        {

            $this->setRequired($param, TRUE);

        }

    }

    /**
     * Set the required status of a parameter.
     *
     * @param string A parameter name.
     * @param bool   The required status.
     * @param string An error message to be used when this parameter has not
     *               been sent or has a length of 0.
     *
     * @access public
     * @since  2.0
     */
    function setRequired ($name, $required, $message = 'Required')
    {

        if (!isset($this->validators[$name]))
        {

            $this->validators[$name] = array();

        }

        $this->validators[$name]['required'] = $required;
        $this->validators[$name]['message']  = $message;

    }

}

?>
