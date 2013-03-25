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
 * Custom authentication handlers reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/auth/.
 *
 * @since 2.0
 * @type  string
 */
define('AUTH_DIR', OPT_DIR . 'auth/');

/**
 * Custom filters reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/filters/.
 *
 * @since 2.0
 * @type  string
 */
define('FILTER_DIR', OPT_DIR . 'filters/');

/**
 * Globally available library files reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>BASE_DIR</i>/lib/.
 *
 * @since 2.0
 * @type  string
 */
define('LIB_DIR', BASE_DIR . 'lib/');

/**
 * Custom logging utilities reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/logging/.
 *
 * @since 2.0
 * @type  string
 */
define('LOGGING_DIR', OPT_DIR . 'logging/');

/**
 * Modules reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>BASE_DIR</i>/modules/.
 *
 * @since 2.0
 * @type  string
 */
define('MODULE_DIR', BASE_DIR . 'modules/');

/**
 * Custom renderers reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/renderers/.
 *
 * @since 2.0
 * @type  string
 */
define('RENDERER_DIR', OPT_DIR . 'renderers/');

/**
 * Custom session handlers reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/session/.
 *
 * @since 2.0
 * @type  string
 */
define('SESSION_DIR', OPT_DIR . 'session/');

/**
 * SQL utilities reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/sql/.
 *
 * @since 2.0
 * @type  string
 */
define('SQL_DIR', OPT_DIR . 'sql/');

/**
 * Globally available templates reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>BASE_DIR</i>/templates/.
 *
 * @since 1.0
 * @type  string
 */
define('TEMPLATE_DIR', BASE_DIR . 'templates/');

/**
 * Custom user persistence and security resides here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/user/.
 *
 * @since 2.0
 * @type  string
 */
define('USER_DIR', OPT_DIR . 'user/');

/**
 * Utility classes reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/util/.
 *
 * @since 2.0
 * @type  string
 */
define('UTIL_DIR', OPT_DIR . 'util/');

/**
 * Custom validators reside here.
 *
 * <br/><br/>
 *
 * This is defined as <i>OPT_DIR</i>/validators/.
 *
 * @since 2.0
 * @type  string
 */
define('VALIDATOR_DIR', OPT_DIR . 'validators/');

/**
 * Format URL's in the typical GET style.
 *
 * <br/><br/>
 *
 * Example: index.php?module=<i>Module</i>&action=<i>Action</i>
 *
 * @since 1.0
 * @type  int
 */
define('GET_FORMAT', 1);

/**
 * Format URL's in a search engine friendly style.
 *
 * <br/><br/>
 *
 * Example: index.php/module/<i>Module</i>/action/<i>Action</i>
 *
 * @since 1.0
 * @type  int
 */
define('PATH_FORMAT', 2);



// include dependencies
require_once(USER_DIR . 'SessionContainer.class.php');



/**
 * Controller dispatches requests to the proper action and controls application
 * flow.
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
class Controller
{

    /**
     * A developer supplied authorization handler.
     *
     * @access private
     * @since  2.0
     * @type   AuthorizationHandler
     */
    var $authorizationHandler;

    /**
     * A user requested content type.
     *
     * @access private
     * @since  2.0
     * @type   string
     */
    var $contentType;

    /**
     * Currently processing action.
     *
     * @access private
     * @since  1.0
     * @type   string
     */
    var $currentAction;

    /**
     * Currently processing module.
     *
     * @access private
     * @since  1.0
     * @type   string
     */
    var $currentModule;

    /**
     * ExecutionChain instance.
     *
     * @access private
     * @since  1.0
     * @type   ExecutionChain
     */
    var $execChain;

    /**
     * An associative array of template-ready data.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $mojavi;

    /**
     * Determines how a view should be rendered.
     *
     * <br/><br/>
     *
     * Possible render modes:
     *
     * <ul>
     *     <li><b>RENDER_CLIENT</b> - render to the client</li>
     *     <li><b>RENDER_VAR</b> - render to variable</li>
     * </ul>
     *
     * @access private
     * @since  2.0
     * @type   int
     */
    var $renderMode;

    /**
     * A Request instance.
     *
     * @access private
     * @since  1.0
     * @type   Request
     */
    var $request;

    /**
     * Originally requested action.
     *
     * @access private
     * @since  1.0
     * @type   string
     */
    var $requestAction;

    /**
     * Originally requested module.
     *
     * @access private
     * @since  1.0
     * @type   string
     */
    var $requestModule;

    /**
     * A developer supplied session handler.
     *
     * @access private
     * @since  2.0
     * @type   SessionHandler
     */
    var $sessionHandler;

    /**
     * A User instance.
     *
     * @access private
     * @since  1.0
     * @type   User
     */
    var $user;

    /**
     * Create a new Controller instance.
     *
     * <br/><br/>
     *
     * <note>
     *     This should never be called manually.
     * </note>
     *
     * @param string A content type.
     *
     * @access private
     * @since  1.0
     */
    function Controller ($contentType = 'html')
    {

        $this->contentType   =  $contentType;
        $this->currentAction =  NULL;
        $this->currentModule =  NULL;
        $this->execChain     =& new ExecutionChain;
        $this->renderMode    =  NULL;
        $this->requestAction =  NULL;
        $this->requestModule =  NULL;

        // init Controller objects
        $this->authorizationHandler =  NULL;
        $this->request              =& new Request($this->parseParameters());
        $this->mojavi               =  array();
        $this->sessionHandler       =  NULL;
        $this->user                 =  NULL;

    }

    /**
     * Determine if an action exists.
     *
     * @param string A module name.
     * @param string An action name.
     *
     * @return bool <b>TRUE</b>, if the given module has the given action,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function actionExists ($modName, $actName)
    {

        $file = BASE_DIR . 'modules/' . $modName . '/actions/' . $actName .
                'Action.class.php';

        return (is_readable($file));

    }

    /**
     * Dispatch a request.
     *
     * <br/><br/>
     *
     * <note>
     *     Optional parameters for module and action exist if you wish to run
     *     Mojavi as a page controller.
     *
     *     <br/><br/>
     *
     *     This method should never be called manually.
     * </note>
     *
     * @param string A module name.
     * @param string An action name.
     */
    function dispatch ($modName = NULL, $actName = NULL)
    {

        // register error handler as default logger's standard() method
        $logger =& LogManager::getLogger();

        // set error handler
        set_error_handler(array(&$logger, 'standard'));

        if ($this->user === NULL)
        {

            // no user type has been set, use the default no privilege user
            $this->user =& new User;

        }

        if (USE_SESSIONS)
        {

            if ($this->sessionHandler !== NULL)
            {

                session_set_save_handler(array(&$this->sessionHandler, 'open'),
                                         array(&$this->sessionHandler, 'close'),
                                         array(&$this->sessionHandler, 'read'),
                                         array(&$this->sessionHandler, 'write'),
                                         array(&$this->sessionHandler, 'destroy'),
                                         array(&$this->sessionHandler, 'gc'));

            }

            // set session container
            if($this->user->getContainer() == NULL)
	    {
	    	$this->user->setContainer(new SessionContainer);
	    }

        }

        $this->user->load();

        // alias mojavi and request objects for easy access
        $mojavi  =& $this->mojavi;
        $request =& $this->request;

        // use default module and action only if both have not been specified
        if ($modName == NULL && !$request->hasParameter(MODULE_ACCESSOR) &&
            $actName == NULL && !$request->hasParameter(ACTION_ACCESSOR))
        {

            $actName = DEFAULT_ACTION;
            $modName = DEFAULT_MODULE;

        } else
        {

            // has a module been specified via dispatch()?
            if ($modName == NULL)
            {

                // a module hasn't been specified via dispatch(), let's check
                // the parameters
                $modName = $request->getParameter(MODULE_ACCESSOR);

            }

            // has an action been specified via dispatch()?
            if ($actName == NULL)
            {

                // an action hasn't been specified via dispatch(), let's check
                // the parameters
                $actName = $request->getParameter(ACTION_ACCESSOR);

                if ($actName == NULL)
                {

                    // does an Index action exist for this module?
                    if ($this->actionExists($modName, 'Index'))
                    {

                        // ok, we found the Index action
                        $actName = 'Index';

                    }

                }

            }

        }

        // if $modName or $actName equal NULL, we don't set them. we'll let
        // ERROR_404_ACTION do it's thing inside forward()

        // replace unwanted characters
        $actName = preg_replace('/[^a-z0-9\-_]+/i', '', $actName);
        $modName = preg_replace('/[^a-z0-9\-_]+/i', '', $modName);

        // set request modules and action
        $this->requestAction      = $actName;
        $this->requestModule      = $modName;
        $mojavi['request_action'] = $actName;
        $mojavi['request_module'] = $modName;

        // paths
        $mojavi['controller_path']     = $this->getControllerPath();
        $mojavi['current_action_path'] = $this->getControllerPath($modName,
                                                                  $actName);

        $mojavi['current_module_path'] = $this->getControllerPath($modName);
        $mojavi['request_action_path'] = $this->getControllerPath($modName,
                                                                  $actName);

        $mojavi['request_module_path'] = $this->getControllerPath($modName);

        // process our originally request action
        $this->forward($modName, $actName);

        // store user data
        $this->user->store();

        // cleanup session handler
        if ($this->sessionHandler !== NULL)
        {

            $this->sessionHandler->cleanup();

        }

        // cleanup loggers
        $logManager =& LogManager::getInstance();
        $logManager->cleanup();

    }

    /**
     * Forward the request to an action.
     *
     * @param string A module name.
     * @param string An action name.
     *
     * @access public
     * @since  2.0
     */
    function forward ($modName, $actName)
    {

        if ($this->currentModule == $modName &&
            $this->currentAction == $actName)
        {

            $error = 'Recursive forward on module ' . $modName . ', action ' .
                     $actName;

            trigger_error($error, E_USER_ERROR);

            exit;

        }

        // execute module configuration, if it exists
        if (is_readable(MODULE_DIR . $modName . '/config.php'))
        {

            require_once(MODULE_DIR . $modName . '/config.php');

        }

        if ($this->actionExists($modName, $actName))
        {

            // create the action instance
            $action =& $this->getAction($modName, $actName);

        } else
        {

            // the requested action doesn't exist
            $action = NULL;

        }

        // track old module/action
        $oldAction = $this->currentAction;
        $oldModule = $this->currentModule;

        // add module and action to execution chain, and update current vars
        $this->execChain->addRequest($modName, $actName, $action);
        $this->updateCurrentVars($modName, $actName);

        if (!AVAILABLE)
        {

            // app is out-of-service
            $actName = UNAVAILABLE_ACTION;
            $modName = UNAVAILABLE_MODULE;

            if (!$this->actionExists($modName, $actName))
            {

                // cannot find unavailable module/action
                $error = 'Invalid configuration setting(s): ' .
                         'UNAVAILABLE_MODULE (' . $modName . ') or ' .
                         'UNAVAILABLE_ACTION (' . $actName . ')';

                trigger_error($error, E_USER_ERROR);

                exit;

            }

            // add another request since the site is unavailable
            $action =& $this->getAction($modName, $actName);

            $this->execChain->addRequest($modName, $actName, $action);
            $this->updateCurrentVars($modName, $actName);

        } else if ($action === NULL)
        {

            // requested action doesn't exist
            $actName = ERROR_404_ACTION;
            $modName = ERROR_404_MODULE;

            if (!$this->actionExists($modName, $actName))
            {

                // cannot find error 404 module/action
                $error = 'Invalid configuration setting(s): ' .
                         'ERROR_404_MODULE (' . $modName . ') or ' .
                         'ERROR_404_ACTION (' . $actName . ')';

                trigger_error($error, E_USER_ERROR);

                exit;

            }

            // add another request since the action is non-existent
            $action =& $this->getAction($modName, $actName);

            $this->execChain->addRequest($modName, $actName, $action);
            $this->updateCurrentVars($modName, $actName);

        }

        $filterChain =& new FilterChain;

        // map filters
        $this->mapGlobalFilters($filterChain);
        $this->mapModuleFilters($filterChain, $modName);

        // and last but not least, the main execution filter
        $filterChain->register(new ExecutionFilter);

        // execute filters
        $filterChain->execute($this, $this->request, $this->user);

        // update current vars
        $this->updateCurrentVars($oldModule, $oldAction);

    }

    /**
     * Generate a formatted Mojavi URL.
     *
     * @param array An associative array of URL parameters.
     *
     * @return string A URL to a Mojavi resource.
     *
     * @access public
     * @since  1.0
     */
    function genURL ($params)
    {

        $url = SCRIPT_PATH;

        if (URL_FORMAT == PATH_FORMAT)
        {

            $divider  = '/';
            $equals   = '/';
            $url     .= '/';

        } else
        {

            // use an else and not a condition to cover any unknown formats
            $divider  = '&';
            $equals   = '=';
            $url     .= '?';

        }

        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            if ($i > 0)
            {

                $url .= $divider;

            }

            $url .= urlencode($keys[$i]) . $equals .
                    urlencode($params[$keys[$i]]);

        }

        return $url;

    }

    /**
     * Retrieve an action implementation instance.
     *
     * @param string A module name.
     * @param string An action name.
     *
     * @return Action An Action instance, if the action exists, otherwise
     *                an error will be reported.
     *
     * @access public
     * @since  1.0
     */
    function & getAction ($modName, $actName)
    {


        $file = BASE_DIR . 'modules/' . $modName . '/actions/' . $actName .
                'Action.class.php';

        require_once($file);

        $action = $actName . 'Action';

        // fix for same name actions
        $modAction = $modName . '_' . $action;

        if (class_exists($modAction))
        {

            $action =& $modAction;

        }
	$tmp_action = & new $action;
        return $tmp_action;

    }

    /**
     * Retrieve the developer supplied authorization handler.
     *
     * @return AuthorizationHandler An AuthorizationHandler instance, if an
     *                              authorization handler has been set,
     *                              otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getAuthorizationHandler ()
    {

        return $this->authorizationHandler;

    }

    /**
     * Retrieve the user supplied content type.
     *
     * @access public
     * @since  1.0
     */
    function getContentType ()
    {

        return $this->contentType;

    }

    /**
     * Retrieve an absolute web path to the public controller file.
     *
     * @param string A module name.
     * @param string An action name.
     *
     * @return string An absolute web path representing the controller file,
     *                which also includes module and action names.
     *
     * @access public
     * @since  1.0
     */
    function getControllerPath ($modName = NULL, $actName = NULL)
    {

        $path = SCRIPT_PATH;

        if ($modName != NULL)
        {

            $path .= (URL_FORMAT == GET_FORMAT)
                     ? '?' . MODULE_ACCESSOR . '=' . $modName
                     : '/' . MODULE_ACCESSOR . '/' . $modName;

        }

        if ($actName != NULL)
        {

            $sep = ($path == SCRIPT_PATH) ? '?' : '&';

            $path .= (URL_FORMAT == GET_FORMAT)
                     ? $sep . ACTION_ACCESSOR . '=' . $actName
                     : '/' . ACTION_ACCESSOR . '/' . $actName;

        }

        return $path;

    }

    /**
     * Retrieve the name of the currently processing action.
     *
     * <br/><br/>
     *
     * <note>
     *     If the request has not been forwarded, this will return the
     *     the originally requested action.
     * </note>
     *
     * @access public
     * @since  1.0
     */
    function getCurrentAction ()
    {

        return $this->currentAction;

    }

    /**
     * Retrieve the name of the currently processing module.
     *
     * <br/><br/>
     *
     * <note>
     *     If the request has not been forwarded, this will return the
     *     originally requested module.
     * </note>
     *
     * @access public
     * @since  1.0
     */
    function getCurrentModule ()
    {

        return $this->currentModule;

    }

    /**
     * Retrieve the execution chain.
     *
     * @return ExecutionChain An ExecutionChain instance.
     *
     * @access public
     * @since  1.0
     */
    function & getExecutionChain ()
    {

        return $this->execChain;

    }

    /**
     * Retrieve the single instance of Controller.
     *
     * @param string A user supplied content type.
     *
     * @return Controller A Controller instance.
     *
     * @access public
     * @since  2.0
     */
    function & getInstance ($contentType = 'html')
    {

        static $instance;

        if ($instance === NULL)
        {

            // can't use reference with static data
            $instance = new Controller($contentType);

        }

        return $instance;

    }

    /**
     * Retrieve an absolute file-system path home directory of the currently
     * processing module.
     *
     * <br/><br/>
     *
     * <note>
     *     If the request has been forwarded, this will return the directory of
     *     the forwarded module.
     * </note>
     *
     * @return string A module directory.
     *
     * @access public
     * @since  2.0
     */
    function getModuleDir ()
    {

        return (BASE_DIR . 'modules/' . $this->currentModule . '/');

    }

    /**
     * Retrieve the Mojavi associative array.
     *
     * @return array An associative array of template-ready data.
     *
     * @access public
     * @since  1.0
     */
    function & getMojavi ()
    {

        return $this->mojavi;

    }

    /**
     * Retrieve the global render mode.
     *
     * <br/><br/>
     *
     * <note>
     *     This will return <b>NULL</b> unless specifically set.
     * </note>
     *
     * @return int One of the two possible render modes:
     *
     *             <ul>
     *                 <li><b>RENDER_CLIENT</b> - render to the client</li>
     *                 <li><b>RENDER_VAR</b> - render to variable</li>
     *             </ul>
     *
     * @access public
     * @since  2.0
     */
    function getRenderMode ()
    {

        return $this->renderMode;

    }

    /**
     * Retrieve the request instance.
     *
     * @return Request A Request instance.
     *
     * @access public
     * @since  1.0
     */
    function & getRequest ()
    {

        return $this->request;

    }

    /**
     * Retrieve the name of the originally requested action.
     *
     * @return string An action name.
     *
     * @access public
     * @since  1.0
     */
    function getRequestAction ()
    {

        return $this->requestAction;

    }

    /**
     * Retrieve the name of the originally requested module.
     *
     * @return string A module name.
     *
     * @access public
     * @since  1.0
     */
    function getRequestModule ()
    {

        return $this->requestModule;

    }

    /**
     * Retrieve the developer supplied session handler.
     *
     * @return SessionHandler A SessionHandler instance, if a session handler
     *                        has been set, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getSessionHandler ()
    {

        return $this->sessionHandler;

    }

    /**
     * Retrieve the currently requesting user.
     *
     * @return User A User instance.
     *
     * @access public
     * @since  1.0
     */
    function & getUser ()
    {

        return $this->user;

    }

    /**
     * Retrieve a view implementation instance.
     *
     * @param string A module name.
     * @param string An action name.
     * @param string A view name.
     *
     * @return View A View instance.
     */
    function & getView ($modName, $actName, $viewName)
    {

        $file = BASE_DIR . 'modules/' . $modName . '/views/' . $actName .
                'View_' . $viewName . '.class.php';

        require_once($file);

        $view =  $actName . 'View';

        // fix for same name views
        $modView = $modName . '_' . $view;

        if (class_exists($modView))
        {

            $view =& $modView;

        }
	$tmp_view = &new $view;
        return $tmp_view;

    }

    /**
     * Map global filters.
     *
     * @param FilterChain A FilterChain instance.
     *
     * @access private
     * @since  1.0
     */
    function mapGlobalFilters (&$filterChain)
    {

        static $list;

        if (!isset($list))
        {

            $file = BASE_DIR . 'GlobalFilterList.class.php';

            if (is_readable($file))
            {

                require_once($file);

                // can't use a reference with a static variable
                $list = new GlobalFilterList;
                $list->registerFilters($filterChain, $this, $this->request,
                                       $this->user);

            }

        } else
        {

            $list->registerFilters($filterChain, $this, $this->request,
                                   $this->user);

        }

    }

    /**
     * Map all filters for a given module.
     *
     * @param FilterChain A FilterChain instance.
     * @param modName     A module name.
     *
     * @access private
     * @since  1.0
     */
    function mapModuleFilters (&$filterChain, $modName)
    {

        static $cache;

        if (!isset($cache))
        {

            $cache = array();

        }

        $listName = $modName . 'FilterList';

        if (!isset($cache[$listName]))
        {

            $file = BASE_DIR . 'modules/' . $modName . '/' . $listName .
                    '.class.php';

            if (is_readable($file))
            {

                require_once($file);

                $list             =& new $listName;
                $cache[$listName] =& $list;

                // register filters
                $list->registerFilters($filterChain, $this, $this->request,
                                       $this->user);

            }

        } else
        {

            $cache[$listName]->registerFilters($filterChain, $this,
                                               $this->request, $this->user);

        }

    }

    /**
     * Parse and retrieve all PATH/REQUEST parameters.
     *
     * @return array An associative array of parameters.
     *
     * @access private
     * @since  1.0
     */
    function & parseParameters ()
    {

        $values = array();

        // load GET params into $values array
        $values = array_merge($values, $_GET);

        // grab PATH_INFO parameters
        if (URL_FORMAT == PATH_FORMAT                                 &&
            ((PATH_INFO_ARRAY == 1 && isset($_SERVER[PATH_INFO_KEY])) ||
             (PATH_INFO_ARRAY == 2 && isset($_ENV[PATH_INFO_KEY]))))
        {

            if (PATH_INFO_ARRAY == 1)
            {

                $array =& $_SERVER;

            } else
            {

                $array =& $_ENV;
            }

            $getArray = explode('/', trim($array[PATH_INFO_KEY], '/'));
            $count    = sizeof($getArray);

            for ($i = 0; $i < $count; $i++)
            {

                // see if there's a value associated with this parameter,
                // if not we're done with path data
                if ($count > ($i + 1))
                {

                    $values[$getArray[$i]] =& $getArray[++$i];

                }

            }

        }

        // load POST params into $values array
        $values = array_merge($values, $_POST);

        // strip slashes from values if magic_quotes_gpc is on
        if (ini_get('magic_quotes_gpc') == 1 && sizeof($values) > 0)
        {

            $this->stripSlashes($values);

        }

        return $values;

    }

    /**
     * Redirect the request to another location.
     *
     * @param string A URL.
     *
     * @access public
     * @since  2.0
     */
    function redirect ($url)
    {

        header('Location: ' . $url);

    }

    /**
     * Set the developer supplied authorization handler.
     *
     * @param Authorizationhandler An AuthorizationHandler instance.
     *
     * @access public
     * @since  2.0
     */
    function setAuthorizationHandler (&$handler)
    {

        $this->authorizationHandler =& $handler;

    }

    /**
     * Set the content type.
     *
     * @param string A user supplied content type.
     *
     * @access public
     * @since  1.0
     */
    function setContentType ($contentType)
    {

        $this->contentType = $contentType;

    }

    /**
     * Set the global render mode.
     *
     * @param int Global render mode, which is one of the following two:
     *
     *            <ul>
     *                <li><b>RENDER_CLIENT</b> - render to the client</li>
     *                <li><b>RENDER_VAR</b> - render to variable</li>
     *            </ul>
     */
    function setRenderMode ($mode)
    {

        $this->renderMode = $mode;

    }

    /**
     * Set the session handler.
     *
     * @param SessionHandler A SessionHandler instance.
     *
     * @access public
     * @since  2.0
     */
    function setSessionHandler (&$handler)
    {

        $this->sessionHandler =& $handler;

    }

    /**
     * Set the user type.
     *
     * @param User A User instance.
     *
     * @access public
     * @since  2.0
     */
    function setUser (&$user)
    {

        $this->user =& $user;

    }

    /**
     * Strip slashes from all parameter values.
     *
     * @param array An associative array of parameters.
     *
     * @access private
     * @since  1.0
     */
    function stripSlashes (&$params)
    {

        $keys  = array_keys($params);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $value =& $params[$keys[$i]];

            if (is_array($value))
            {

                // traverse through the array and strip some more crap, oops
                // i mean magic_quotes_gpc leftovers
                $this->stripSlashes($value);

            } else
            {

                // bug fixed by wolfpakz
                $value = stripslashes($value);

            }

        }

    }

    /**
     * Update current module and action data.
     *
     * @param string A module name.
     * @param string An action name.
     *
     * @access private
     * @since  1.0
     */
    function updateCurrentVars ($modName, $actName)
    {

        // alias objects for easy access
        $mojavi =& $this->mojavi;

        $this->currentModule = $modName;
        $this->currentAction = $actName;

        // names
        $mojavi['current_action'] = $actName;
        $mojavi['current_module'] = $modName;

        // directories
        $mojavi['module_dir']   = BASE_DIR . 'modules/';
        $mojavi['template_dir'] = BASE_DIR . 'modules/' . $modName .
                                  '/templates/';

        // paths
        $mojavi['current_action_path'] = $this->getControllerPath($modName,
                                                                  $actName);
        $mojavi['current_module_path'] = $this->getControllerPath($modName);

    }

    /**
     * Determine if a view exists.
     *
     * @param string A module name.
     * @param string An action name.
     * @param string A view name.
     *
     * @return bool <b>TRUE</b>, if the view exists, otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function viewExists ($modName, $actName, $viewName)
    {

        $file = BASE_DIR . 'modules/' . $modName . '/views/' . $actName .
                'View_' . $viewName . '.class.php';

        return (is_readable($file));

    }

}

// set the display error status
ini_set('display_errors', DISPLAY_ERRORS);

?>
