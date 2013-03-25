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
 * An ActionChain implementation allows you to execute multiple actions and
 * retrieve their results. This makes it a prime candidate for retrieving
 * information from external Action implementations.
 *
 * <br/><br/>
 *
 * <note>
 *     This class does not need to be included. It is part of the main library.
 * </note>
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   2.0
 */
class ActionChain
{

    /**
     * An associative array of actions.
     *
     * @access private
     * @since  2.0
     * @type   array
     */
    var $actions;

    /**
     * Whether or not to preserve request parameters while actions are being
     * executed.
     *
     * @access private
     * @since  2.0
     * @type   bool
     */
    var $preserve;

    /**
     * Create a new ActionChain instance.
     *
     * @access public
     * @since  2.0
     */
    function ActionChain ()
    {

        $this->actions  = array();
        $this->preserve = FALSE;

    }

    /**
     * Execute all registered actions.
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
    function execute (&$controller, &$request, &$user)
    {

        $keys  = array_keys($this->actions);
        $count = sizeof($keys);

        // retrieve current render mode
        $renderMode = $controller->getRenderMode();

        // force all actions at this point to render to variable
        $controller->setRenderMode(RENDER_VAR);

        for ($i = 0; $i < $count; $i++)
        {

            $action =& $this->actions[$keys[$i]];

            if ($this->preserve && $action['params'] != NULL)
            {

                // make a copy of the current variables if they exist
                $params   = array();
                $subKeys  = array_keys($action['params']);
                $subCount = sizeof($subKeys);

                for ($x = 0; $x < $subCount; $x++)
                {

                    if ($request->hasParameter($subKeys[$x]))
                    {

                        // do not use a reference here
                        $params[$subKeys[$x]] = $request->getParameter($subKeys[$x]);

                    }

                }

            }

            if ($action['params'] != NULL)
            {

                // add replacement parameters to the request
                $subKeys  = array_keys($action['params']);
                $subCount = sizeof($subKeys);

                for ($x = 0; $x < $subCount; $x++)
                {

                    $request->setParameterByRef($subKeys[$x],
                                                $action['params'][$subKeys[$x]]);

                }

            }

            // execute/forward the action and retrieve rendered result
            $controller->forward($action['module'], $action['action']);

            // retrieve renderer for action
            $renderer =& $request->getAttribute('org.mojavi.renderer');

            // did the action render a view?
            if ($renderer !== NULL)
            {

                // retrieve rendered result
                $action['result'] = $renderer->fetchResult($controller,
                                                           $request,
                                                           $user);

                // clear rendered result
                $renderer->clearResult();

                // remove renderer
                $request->removeAttribute('org.mojavi.renderer');

            }

            if (isset($params))
            {

                // put copies of parameters back
                $subKeys  = array_keys($params);
                $subCount = sizeof($subKeys);

                for ($x = 0; $x < $subCount; $x++)
                {

                    $request->setParameterByRef($subKeys[$x],
                                                $params[$subKeys[$x]]);

                }

                unset($params);

            }

        }

        // put the old rendermode back
        $controller->setRenderMode($renderMode);

    }

    /**
     * Fetch the result of an executed action.
     *
     * @param string An action registration name.
     *
     * @return string A rendered view, if the given action exists and did render
     *                a view, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & fetchResult ($regName)
    {

        if (isset($this->actions[$regName]['result']))
        {

            return $this->actions[$regName]['result'];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Register an action with the chain.
     *
     * @param string An action registration name.
     * @param string A module name.
     * @param string An action name.
     * @param array  An associative array of temporary request parameters.
     *
     * @access public
     * @since  2.0
     */
    function register ($regName, $modName, $actName, $params = NULL)
    {

        $this->actions[$regName]['action'] = $actName;
        $this->actions[$regName]['module'] = $modName;
        $this->actions[$regName]['params'] = $params;

    }

    /**
     * Set the parameter preservation status.
     *
     * @param bool A preservation status.
     *
     * @access public
     * @since  2.0
     */
    function setPreserve ($preserve)
    {

        $this->preserve = $preserve;

    }

}

?>
