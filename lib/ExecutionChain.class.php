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
 * ExecutionChain allows you to view all executed actions for a single request.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class ExecutionChain
{

    /**
     * An indexed array of executed actions.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $chain;

    /**
     * Create a new ExecutionChain instance.
     *
     * @access public
     * @since  1.0
     */
    function ExecutionChain ()
    {

        $this->chain = array();

    }

    /**
     * Add an action request to the chain.
     *
     * @param string A module name.
     * @param string An action name.
     * @param string An Action instance.
     *
     * @access public
     * @since  1.0
     */
    function addRequest ($modName, $actName, &$action)
    {

        $this->chain[] = array('module_name' => $modName,
                               'action_name' => $actName,
                               'action'      => &$action,
                               'microtime'   => microtime());

    }

    /**
     * Retrieve the Action instance at the given index.
     *
     * @param int The index from which you're retrieving.
     *
     * @return Action An Action instance, if the given index exists and the
     *                action was executed, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & getAction ($index)
    {

        if (sizeof($this->chain) > $index && $index > -1)
        {

            return $this->chain[$index]['action'];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve the action name associated with the request at the given index.
     *
     * @param int The index from which you're retrieving.
     *
     * @return string An action name, if the given index exists, otherwise
     *                <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function getActionName ($index)
    {

        if (sizeof($this->chain) > $index && $index > -1)
        {

            return $this->chain[$index]['action_name'];

        }

        return NULL;

    }

    /**
     * Retrieve the module name associated with the request at the given index.
     *
     * @param int The index from which you're retrieving.
     *
     * @return string A module name, if the given index exists, otherwise
     *                <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function getModuleName ($index)
    {

        if (sizeof($this->chain) > $index && $index > -1)
        {

            return $this->chain[$index]['module_name'];

        }

        return NULL;

    }

    /**
     * Retrieve a request and its associated data.
     *
     * @param int The index from which you're retrieving.
     *
     * @return array An associative array containing information about an action
     *               request.
     *
     * @access public
     * @since  1.0
     */
    function & getRequest ($index)
    {

        if (sizeof($this->chain) > $index && $index > -1)
        {

            return $this->chain[$index];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve all requests and their associated data.
     *
     * @return array An indexed array of action requests.
     *
     * @access public
     * @since  1.0
     */
    function & getRequests ()
    {

        return $this->chain;

    }

    /**
     * Retrieve the size of the chain.
     *
     * @return int The size of the chain.
     *
     * @access public
     * @since  1.0
     */
    function getSize ()
    {

        return sizeof($this->chain);

    }

}

?>
