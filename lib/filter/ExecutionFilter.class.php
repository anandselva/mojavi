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
 * ExecutionFilter is the main filter that does controls the validation, action
 * execution and view rendering.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package filter
 * @since   1.0
 */
class ExecutionFilter extends Filter
{

    /**
     * Create a new ExecutionFilter instance.
     *
     * @access public
     * @since  2.0
     */
    function ExecutionFilter ()
    {

        parent::Filter();

    }

    /**
     * Execute this filter.
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
     *
     * @access public
     * @since  1.0
     */
    function execute (&$filterChain, &$controller, &$request, &$user)
    {

        // retrieve current action instance
        $execChain =& $controller->getExecutionChain();
        $action    =& $execChain->getAction($execChain->getSize() - 1);
        $actName   =  $controller->getCurrentAction();
        $modName   =  $controller->getCurrentModule();

        // get current method
        $method = $request->getMethod();

        // initialize the action
        if ($action->initialize($controller, $request, $user))
        {

            // does this action require authentication and authorization?
            if ($action->isSecure())
            {

                // get authorization handler and required privilege
                $authHandler =& $controller->getAuthorizationHandler();

                if ($authHandler === NULL)
                {

                    // log invalid security notice
                    trigger_error('Action requires security but no authorization ' .
                                  'handler has been registered', E_USER_NOTICE);

                } else if (!$authHandler->execute($controller, $request, $user, $action))
                {

                    // user doesn't have access
                    return;

                }

                // user has access or no authorization handler has been set

            }

            if (($action->getRequestMethods() & $method) != $method)
            {

                // this action doesn't handle the current request method,
                // use the default view
                $actView = $action->getDefaultView($controller, $request, $user);

            } else
            {

                // create a ValidatorManager instance
                $validManager =& new ValidatorManager;

                // register individual validators
                $action->registerValidators($validManager, $controller, $request,
                                            $user);

                // check individual validators, and if they succeed,
                // validate entire request
                if (!$validManager->execute($controller, $request, $user) ||
                    !$action->validate($controller, $request, $user))
                {

                    // one or more individual validators failed or
                    // request validation failed
                    $actView = $action->handleError($controller, $request, $user);

                } else
                {

                    // execute the action
                    $actView = $action->execute($controller, $request, $user);

                }

            }

            if (is_string($actView) || $actView === NULL)
            {

                // use current action for view
                $viewMod  = $modName;
                $viewAct  = $actName;
                $viewName = $actView;

            } else if (is_array($actView))
            {

                // use another action for view
                $viewMod  = $actView[0];
                $viewAct  = $actView[1];
                $viewName = $actView[2];

            }

            if ($viewName != VIEW_NONE)
            {

                if (!$controller->viewExists($viewMod, $viewAct, $viewName))
                {

                    $error = 'Module ' . $viewMod . ' does not contain view ' .
                             $viewAct . 'View_' . $viewName . ' or the file is ' .
                             'not readable';

                    trigger_error($error, E_USER_ERROR);

                    exit;

                }

                // execute, render and cleanup view
                $view     =& $controller->getView($viewMod, $viewAct, $viewName);
                $test = $view->initialize($controller,$request,$user); 
		$renderer =& $view->execute($controller, $request, $user);
		
                $renderer->execute($controller, $request, $user);
                $view->cleanup($controller, $request, $user);

                // add the renderer to the request
                $request->setAttributeByRef('org.mojavi.renderer', $renderer);

            }

        }

    }

}

?>
