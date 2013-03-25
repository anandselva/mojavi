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
 * Filter allows you to intercept a request and handle pre-action execution or
 * control the result of an action after it has been executed.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package filter
 * @since   1.0
 */
class Filter
{

    /**
     * An associative array of initialization parameters.
     *
     * @access protected
     * @since  2.0
     * @type   array
     */
    var $params;

    /**
     * Create a new Filter instance.
     *
     * @access public
     * @since  1.0
     */
    function Filter ()
    {

        $this->params = array();

    }

    /**
     * Execute the filter.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @param FilterChain A FilterChain instance.
     * @param Controller  A Controller instance.
     * @param Request     A Request instance.
     * @param User        A User instance.
     */
    function execute (&$filterChain, &$controller, &$request, &$user)
    {

        $error = 'Filter::execute(&$filterChain, &$controller, &$request, ' .
                 '&$user) must be overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

    /**
     * Initialize the filter.
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

}

?>
