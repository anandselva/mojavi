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
 * FilterChain controls filter execution.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package filter
 * @since   1.0
 */
class FilterChain
{

    /**
     * The current index at which the chain is processing.
     *
     * @access private
     * @since  1.0
     * @type   int
     */
    var $index;

    /**
     * An indexed array of filters.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $filters;

    /**
     * Create a new FilterChain instance.
     *
     * @access public
     * @since  1.0
     */
    function FilterChain ()
    {

        $this->index = -1;
        $this->filters = array();

    }

    /**
     * Execute the next filter in the chain.
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

        if (++$this->index < sizeof($this->filters))
        {

            $this->filters[$this->index]->execute($this, $controller,
                                                      $request, $user);

        }

    }

    /**
     * Register a filter.
     *
     * @param Filter A Filter instance.
     *
     * @access public
     * @since  1.0
     */
    function register (&$filter)
    {

        $this->filters[] =& $filter;

    }

}

?>
