<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003 Sean Kerr.                                             |
// |                                                                           |
// | For the full copyright and license information, please view the COPYRIGHT |
// | file that was distributed with this source code. If the COPYRIGHT file is |
// | missing, please visit the Mojavi homepage: http://www.mojavi.org          |
// +---------------------------------------------------------------------------+

/* include filter classes here */

// require_once(FILTER_DIR . 'ExecutionTimeFilter.class.php');

class GlobalFilterList extends FilterList
{

    /**
     * Create a new GlobalFilterList instance.
     *
     * @access public
     * @since  1.0
     */
    function GlobalFilterList ()
    {

        parent::FilterList();

        /* create filter instances here */

        // $this->filters['ExecutionTimeFilter'] =& new ExecutionTimeFilter;

    }

}

?>
