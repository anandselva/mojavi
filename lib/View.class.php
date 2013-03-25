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
 * Render an alert view.
 *
 * <br/><br/>
 *
 * This is defined as <i>alert</i>.
 *
 * @since 1.0
 * @type  string
 */
define('VIEW_ALERT', 'alert');

/**
 * Render an error view.
 *
 * <br/><br/>
 *
 * This is defined as <i>error</i>.
 *
 * @since 1.0
 * @type  string
 */
define('VIEW_ERROR', 'error');

/**
 * Render an index view.
 *
 * <br/><br/>
 *
 * This is defined as <i>index</i>.
 *
 * @since 1.0
 * @type  string
 */
define('VIEW_INDEX', 'index');

/**
 * Render an input view.
 *
 * <br/><br/>
 *
 * This is defined as <i>input</i>.
 *
 * @since 1.0
 * @type  string
 */
define('VIEW_INPUT', 'input');

/**
 * Do not render a view.
 *
 * <br/><br/>
 *
 * This is defined as <b>NULL</b>.
 *
 * @since 1.0
 * @type  <b>NULL</b>
 */
define('VIEW_NONE', NULL);

/**
 * Render a success view.
 *
 * <br/><br/>
 *
 * This is defined as <i>success</i>.
 *
 * @since 1.0
 * @type  string
 */
define('VIEW_SUCCESS', 'success');

/**
 * View represents a presentation layer for an action.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class View
{

    /**
     * Create a new View instance.
     *
     * @access public
     * @since  1.0
     */
    function View ()
    {

    }

    /**
     * Cleanup temporary view data.
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
     * @since  2.0
     */
    function cleanup (&$controller, &$request, &$user)
    {

    }

   /**
     * Initialize common view parameters.
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
     * @since  2.0
     */
    function initialize (&$controller, &$request, &$user)
    {
	return true;
    }


    /**
     * Render the presentation.
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
     * @return Renderer A Renderer instance.
     *
     * @access public
     * @since  1.0
     */
    function & execute (&$controller, &$request, &$user)
    {

        $error = 'View::execute(&$controller, &$request, &$user) must be ' .
                 'overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

}

?>
