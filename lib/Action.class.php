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
 * All Action implementations must extend this class. An Action implementation
 * is used to execute business logic, which should be encapsulated in a model. A
 * model is a class that provides methods to manipulate data that is linked to
 * something, such as a database.
 *
 * <br/><br/>
 *
 * <note>
 *     This class does not need to be included. It is part of the main library.
 * </note>
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class Action
{

    /**
     * Create a new Action instance.
     *
     * @access public
     * @since  1.0
     */
    function Action ()
    {

    }

    /**
     * Execute all business logic.
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
     * @return mixed A single string value describing the view or an indexed
     *               array coinciding with the following list:
     *
     *               <ul>
     *                   <li><b>1st index</b> - module name</li>
     *                   <li><b>2nd index</b> - action name</li>
     *                   <li><b>3rd index</b> - view name</li>
     *               </ul>
     *
     * @access public
     * @since  1.0
     */
    function execute (&$controller, &$request, &$user)
    {

        $error = 'Action::execute(&$controller, &$request, &$user) must be ' .
                 'overridden';

        trigger_error($error, E_USER_ERROR);

        exit;

    }

    /**
     * Retrieve the default view.
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return mixed <use method="execute"/>
     *
     * @access public
     * @since  1.0
     */
    function getDefaultView (&$controller, &$request, &$user)
    {

        return VIEW_INPUT;

    }

    /**
     * Retrieve the privilege required to access this action.
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return array An indexed array coinciding with the following list:
     *
     *               <ul>
     *                   <li><b>1st index</b> - privilege name</li>
     *                   <li><b>2nd index</b> - privilege namespace
     *                       (optional)</li>
     *               </ul>
     *
     * @access public
     * @see    isSecure()
     * @since  1.0
     */
    function getPrivilege (&$controller, &$request, &$user)
    {

        return NULL;

    }

    /**
     * Retrieve the HTTP request method(s) this action will serve.
     *
     * @return int A request method that is one of the following:
     *
     *             <ul>
     *                 <li><b>REQ_GET</b> - serve GET requests</li>
     *                 <li><b>REQ_POST</b> - serve POST requests</li>
     *             </ul>
     *
     * @access public
     * @since  1.0
     */
    function getRequestMethods ()
    {

        return REQ_GET | REQ_POST;

    }

    /**
     * Handle a validation error.
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return mixed <use method="execute"/>
     *
     * @access public
     * @since  1.0
     */
    function handleError (&$controller, &$request, &$user)
    {

        return VIEW_ERROR;

    }

    /**
     * Execute action initialization procedure.
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return bool <b>TRUE</b>, if this action initializes successfully,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function initialize (&$controller, &$request, &$user)
    {

        return TRUE;

    }

    /**
     * Determine if this action requires authentication.
     *
     * @return bool <b>TRUE</b>, if this action requires authentication,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function isSecure ()
    {

        return FALSE;

    }

    /**
     * Register individual parameter validators.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @param ValidatorManager A ValidatorManager instance.
     * @param Controller       A Controller instance.
     * @param Request          A Request instance.
     * @param User             A User instance.
     *
     * @access public
     * @since  1.0
     */
    function registerValidators (&$validatorManager, &$controller, &$request,
                                 &$user)
    {

    }

    /**
     * Validate the request as a whole.
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
     * @return bool <b>TRUE</b>, if validation completes successfully, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function validate (&$controller, &$request, &$user)
    {

        return TRUE;

    }

}

?>
