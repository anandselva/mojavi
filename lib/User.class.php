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
 * User provides a clean interface to a single user, which allows for easy
 * manipulation of attributes and security related data.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class User
{

    /**
     * The authenticated status of the user.
     *
     * @access private
     * @since  1.0
     * @type   bool
     */
    var $authenticated;

    /**
     * An associative array of attributes.
     *
     * @access private
     * @since  1.0
     * @type   bool
     */
    var $attributes;

    /**
     * Container instance.
     *
     * @access private
     * @since  1.0
     * @type   bool
     */
    var $container;

    /**
     * Security related data
     *
     * @access private
     * @since  1.0
     * @type   mixed
     */
    var $secure;

    /**
     * Create a new User instance.
     *
     * @access public
     * @since  1.0
     */
    function User ()
    {

        $this->authenticated = NULL;
        $this->attributes    = NULL;
        $this->container     = NULL;
        $this->secure        = NULL;

    }

    /**
     * Clear all user data.
     *
     * @access public
     * @since  2.0
     */
    function clearAll ()
    {

        $this->authenticated = FALSE;
        $this->attributes    = NULL;
        $this->attributes    = array();
        $this->secure        = NULL;
        $this->secure        = array();

    }

    /**
     * Clear all attribute namespaces and their associated attributes.
     *
     * @access public
     * @since  2.0
     */
    function clearAttributes ()
    {

        $this->attributes = NULL;
        $this->attributes = array();

    }

    /**
     * Retrieve an attribute.
     *
     * @param string An attribute name.
     * @param string An attribute namespace.
     *
     * @return mixed An attribute value, if the given attribute exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getAttribute ($name, $namespace = 'org.mojavi')
    {

        $namespace =& $this->getAttributes($namespace);

        if ($namespace != NULL && isset($namespace[$name]))
        {

            return $namespace[$name];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve an indexed array of attribute names.
     *
     * @return array An array of attribute names, if the given namespace exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function getAttributeNames ($namespace = 'org.mojavi')
    {

        $namespace =& $this->getAttributes($namespace);

        return ($namespace != NULL) ? array_keys($namespace) : NULL;

    }

    /**
     * Retrieve an indexed array of attribute namespaces.
     *
     * @return array An array of attribute namespaces.
     *
     * @access public
     * @since  2.0
     */
    function getAttributeNamespaces ()
    {

        return array_keys($this->attributes);

    }

    /**
     * Retrieve an associative array of namespace attributes.
     *
     * @param string An attribute namespace.
     * @param bool   Whether or not to auto-create the attribute namespace
     *               if it doesn't already exist.
     *
     * @return array An array of attributes, if the given namespace exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  2.0
     */
    function & getAttributes ($namespace, $create = FALSE)
    {

        if (isset($this->attributes[$namespace]))
        {

            return $this->attributes[$namespace];

        } else if ($create)
        {

            $this->attributes[$namespace] = array();

            return $this->attributes[$namespace];

        }

	$null = NULL;
        return $null;
    }

    /**
     * Retrieve the container.
     *
     * @return Container A Container instance.
     *
     * @access public
     * @since  2.0
     */
    function & getContainer ()
    {

        return $this->container;

    }

    /**
     * Determine if the user has an attribute.
     *
     * @param string An attribute name.
     * @param string An attribute namespace.
     *
     * @return bool <b>TRUE</b>, if the given attribute exists, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function hasAttribute ($name, $namespace = 'org.mojavi')
    {

        $namespace =& $this->getAttributes($namespace);

        return ($namespace != NULL && isset($namespace[$name])) ? TRUE : FALSE;

    }

    /**
     * Determine the authenticated status of the user.
     *
     * @return bool <b>TRUE</b>, if the user is authenticated, otherwise
     *              <b>FALSE</b>.
     *
     * @access public
     * @since  1.0
     */
    function isAuthenticated ()
    {

        return ($this->authenticated === TRUE) ? TRUE : FALSE;

    }

    /**
     * Load data from the container.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @access public
     * @since  2.0
     */
    function load ()
    {

        if ($this->container !== NULL)
        {

            $this->container->load($this->authenticated, $this->attributes,
                                   $this->secure);

        }

    }

    /**
     * Merge a new set of attributes with the existing set.
     *
     * @param array An associative array of attributes.
     *
     * @access public
     * @since  2.0
     */
    function mergeAttributes ($attributes)
    {

        $keys  = array_keys($attributes);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            if (isset($this->attributes[$keys[$i]]))
            {

                // namespace already exists, merge values only
                $subKeys  = array_keys($attributes[$keys[$i]]);
                $subCount = sizeof($subKeys);

                for ($x = 0; $x < $subCount; $x++)
                {

                    $this->attributes[$keys[$i]][$subKeys[$x]] =& $attributes[$keys[$i]][$subKeys[$x]];

                }

            } else
            {

                // merge entire value
                $this->attributes[$keys[$i]] =& $attributes[$keys[$i]];

            }

        }

    }

    /**
     * Remove an attribute.
     *
     * @param string An attribute name.
     * @param string An attribute namespace.
     *
     * @return mixed An attribute value, if the given attribute exists and has
     *               been removed, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & removeAttribute ($name, $namespace = 'org.mojavi')
    {

        $namespace =& $this->getAttributes($namespace);

        if ($namespace !== NULL && isset($namespace[$name]))
        {

            $value =& $namespace[$name];

            unset($namespace[$name]);

            return $value;

        }

	$null = NULL;
        return $null;
    }

    /**
     * Remove an attribute namespace and all associated attributes.
     *
     * @param string An attribute namespace.
     *
     * @access public
     * @since  1.0
     */
    function removeAttributes ($namespace = 'org.mojavi')
    {

        $namespace =& $this->getAttributes($namespace);
        $namespace =  NULL;

    }

    /**
     * Set an attribute.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     * @param string An attribute namespace.
     *
     * @access public
     * @since  1.0
     */
    function setAttribute ($name, $value, $namespace = 'org.mojavi')
    {

        $namespace        =& $this->getAttributes($namespace, TRUE);
        $namespace[$name] =  $value;

    }

    /**
     * Set an attribute by reference.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     * @param string An attribute namespace.
     *
     * @access public
     * @since  1.0
     */
    function setAttributeByRef ($name, &$value, $namespace = 'org.mojavi')
    {

        $namespace        =& $this->getAttributes($namespace, TRUE);
        $namespace[$name] =& $value;

    }

    /**
     * Set the authenticated status of the user.
     *
     * @param bool The authentication status.
     *
     * @access public
     * @since  1.0
     */
    function setAuthenticated ($status)
    {

        $this->authenticated = $status;

    }

    /**
     * Set the container.
     *
     * @param Container A Container instance.
     *
     * @access public
     * @since  2.0
     */
    function setContainer (&$container)
    {

        $this->container =& $container;

    }

    /**
     * Store data in the container.
     *
     * <br/><br/>
     *
     * <note>
     *     This method should never be called manually.
     * </note>
     *
     * @access public
     * @since  2.0
     */
    function store ()
    {

        if ($this->container !== NULL)
        {

            $this->container->store($this->authenticated, $this->attributes,
                                    $this->secure);

        }

    }

}

?>
