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
 * FilterList allows you to register a list of filters in a specific order.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @package filter
 * @since   1.0
 */
class FilterList
{

    /**
     * An associative array of filters.
     *
     * @access private
     * @since  1.0
     * @var    array
     */
    var $filters;

    /**
     * Create a new FilterList instance.
     *
     * @access public
     * @since  1.0
     */
    function FilterList ()
    {

        $this->filters = array();

    }

    /**
     * Register filters.
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
    function registerFilters (&$filterChain, &$controller, &$request, &$user)
    {

        $keys  = array_keys($this->filters);
        $count = sizeof($keys);

        // loop through cached filters and register them
        for ($i = 0; $i < $count; $i++)
        {

            $filterChain->register($this->filters[$keys[$i]]);

        }

    }

}

?>
