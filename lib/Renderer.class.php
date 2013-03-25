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
 * Render the view to the client.
 *
 * <br/><br/>
 *
 * This is defined as 1.
 *
 * @since 2.0
 * @type  int
 */
define('RENDER_CLIENT', 1);

/**
 * Render the view to a variable.
 *
 * <br/><br/>
 *
 * This is defined as 2.
 *
 * @since 2.0
 * @type  int
 */
define('RENDER_VAR', 2);

/**
 * Renderer renders a PHP template file.
 *
 * @author  Sean Kerr
 * @package mojavi
 * @since   1.0
 */
class Renderer
{

    /**
     * An associative array of template attributes.
     *
     * @access private
     * @since  1.0
     * @type   array
     */
    var $attributes;

    /**
     * An absolute file-system path where a template can be found.
     *
     * @access protected
     * @since  1.0
     * @type   string
     */
    var $dir;

    /**
     * The template engine instance.
     *
     * @access protected
     * @since  2.0
     * @type   object
     */
    var $engine;

    /**
     * The mode to be used for rendering, which is one of the following:
     *
     * <ul>
     *     <li><b>RENDER_CLIENT</b> - render to client</li>
     *     <li><b>RENDER_VAR</b> - render to variable</li>
     * </ul>
     *
     * @access private
     * @since  2.0
     * @type   int
     */
    var $mode;

    /**
     * The result of a render when render mode is <b>RENDER_VAR</b>.
     *
     * @access protected
     * @since  2.0
     * @type   string
     */
    var $result;

    /**
     * A relative or absolute file-system path to a template.
     *
     * @access protected
     * @since  1.0
     * @type   string
     */
    var $template;

    /**
     * Create a new Renderer instance.
     *
     * @access public
     * @since  1.0
     */
    function Renderer ()
    {

        $this->attributes = array();
        $this->dir        = NULL;
        $this->engine     = NULL;
        $this->mode       = RENDER_CLIENT;
        $this->result     = NULL;
        $this->template   = NULL;

    }

    /**
     * Clear the rendered result.
     *
     * <br/><br/>
     *
     * <note>
     *     This is only useful when render mode is <b>RENDER_VAR</b>.
     * </note>
     */
    function clearResult ()
    {

        if ($this->result != NULL)
        {

            unset($this->result);

        }

        $this->result = NULL;

    }

    /**
     * Render the view.
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

        $dir = NULL;

        if ($this->template == NULL)
        {

            $error = 'A template has not been specified';

            trigger_error($error, E_USER_ERROR);

            exit;

        }

        if ($this->isPathAbsolute($this->template))
        {

            $dir            = dirname($this->template) . '/';
            $this->template = basename($this->template);

        } else
        {

            $dir = ($this->dir == NULL)
                   ? $controller->getModuleDir() . 'templates/'
                   : $this->dir;

            if (!is_readable($dir . $this->template) &&
                 is_readable(TEMPLATE_DIR . $this->template))
            {

                $dir = TEMPLATE_DIR;

            }

        }

        if (is_readable($dir . $this->template))
        {

            // make it easier to access data directly in the template
            $mojavi   =& $controller->getMojavi();
            $template =& $this->attributes;

            if ($this->mode == RENDER_VAR ||
                $controller->getRenderMode() == RENDER_VAR)
            {

                ob_start();

                require($dir . $this->template);

                $this->result = ob_get_contents();

                ob_end_clean();

            } else
            {

                require($dir . $this->template);

            }

        } else
        {

            $error = 'Template file ' . $dir . $this->template . ' does ' .
                     'not exist or is not readable';

            trigger_error($error, E_USER_ERROR);

            exit;

        }

    }

    /**
     * Retrieve the rendered result when render mode is <b>RENDER_VAR</b>.
     *
     * @param Controller A Controller instance.
     * @param Request    A Request instance.
     * @param User       A User instance.
     *
     * @return string A rendered view.
     *
     * @access public
     * @since  2.0
     */
    function & fetchResult (&$controller, &$request, &$user)
    {

        if ($this->mode == RENDER_VAR ||
            $controller->getRenderMode() == RENDER_VAR)
        {

            if ($this->result == NULL)
            {

                $this->execute($controller, $request, $user);

            }

            return $this->result;

        }

	$null = NULL;
	return $null;
    }

    /**
     * Retrieve an attribute.
     *
     * @param string An attribute name.
     *
     * @return mixed An attribute value, if the given attribute exists,
     *               otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
    function & getAttribute ($name)
    {

        if (isset($this->attributes[$name]))
        {

            return $this->attributes[$name];

        }

	$null = NULL;
	return $null;
    }

    /**
     * Retrieve the template engine instance.
     *
     * @return bool <b>NULL</b> because no template engine exists for PHP
     *              templates.
     *
     * @access public
     * @since  2.0
     */
    function & getEngine ()
    {

        return $this->engine;

    }

    /**
     * Retrieve the render mode, which is one of the following:
     *
     * <ul>
     *     <li><b>RENDER_CLIENT</b> - render to client</li>
     *     <li><b>RENDER_VAR</b> - render to variable</li>
     * </ul>
     *
     * @return int A render mode.
     */
    function getMode ()
    {

        return $this->mode;

    }

    /**
     * Retrieve an absolute file-system path to the template directory.
     *
     * <br/><br/>
     *
     * <note>
     *     This will return <b>NULL</b> unless a directory has been specified
     *     with <i>setTemplateDir()</i>.
     * </note>
     *
     * @return string A template directory.
     *
     * @access public
     * @since  1.0
     */
    function getTemplateDir ()
    {

        return $this->dir;

    }

    /**
     * Determine if a file-system path is absolute.
     *
     * @param string A file-system path.
     *
     * @access public
     * @since  2.0
     */
    function isPathAbsolute ($path)
    {

        if (strlen($path) >= 2)
        {

            if ($path{0} == '/' || $path{0} == "\\" || $path{1} == ':')
            {

                return TRUE;

            }

        }

        return FALSE;

    }

    /**
     * Remove an attribute.
     *
     * @param string An attribute name.
     *
     * @access public
     * @since  1.0
     */
    function & removeAttribute ($name)
    {

        if (isset($this->attributes[$name]))
        {

            unset($this->attributes[$name]);

        }

    }

    /**
     * Set multiple attributes by using an associative array.
     *
     * @param array An associative array of attributes.
     *
     * @access public
     * @since  2.0
     */
    function setArray ($array)
    {

        $this->attributes = array_merge($this->attributes, $array);

    }

    /**
     * Set multiple attributes by using a reference to an associative array.
     *
     * @param array An associative array of attributes.
     *
     * @access public
     * @since  2.0
     */
    function setArrayByRef (&$array)
    {

        $keys  = array_keys($array);
        $count = sizeof($keys);

        for ($i = 0; $i < $count; $i++)
        {

            $this->attributes[$keys[$i]] =& $array[$keys[$i]];

        }

    }

    /**
     * Set an attribute.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     *
     * @access public
     * @since  1.0
     */
    function setAttribute ($name, $value)
    {

        $this->attributes[$name] = $value;

    }

    /**
     * Set an attribute by reference.
     *
     * @param string An attribute name.
     * @param mixed  An attribute value.
     *
     * @access public
     * @since  1.0
     */
    function setAttributeByRef ($name, &$value)
    {

        $this->attributes[$name] =& $value;

    }

    /**
     * Set the render mode, which is one of the following:
     *
     * <ul>
     *     <li><b>RENDER_CLIENT</b> - render to client</li>
     *     <li><b>RENDER_VAR</b> - render to variable</li>
     * </ul>
     *
     * @param int A render mode.
     *
     * @access public
     * @since  2.0
     */
    function setMode ($mode)
    {

        $this->mode = $mode;

    }

    /**
     * Set the template.
     *
     * @param template A relative or absolute file-system path to a template.
     *
     * @access public
     * @since  1.0
     */
    function setTemplate ($template)
    {

        $this->template = $template;

    }

    /**
     * Set the template directory.
     *
     * @param dir An absolute file-system path to the template directory.
     *
     * @access public
     * @since  1.0
     */
    function setTemplateDir ($dir)
    {

        $this->dir = $dir;

        if (substr($dir, -1) != '/')
        {

            $this->dir .= '/';

        }

    }

    /**
     * Determine if a template exists.
     *
     * @param template A relative or absolute file-system path to the template.
     * @param dir      An absolute file-system path to the template directory.
     *
     * @return bool <b>TRUE</b>, if the template exists and is readable,
     *              otherwise <b>FALSE</b>.
     *
     * @access public
     * @since  2.0
     */
    function templateExists ($template, $dir = NULL)
    {

        if ($this->isPathAbsolute($template))
        {

            $dir      = dirname($template) . '/';
            $template = basename($template);

        } else if ($dir == NULL)
        {

            $dir = $this->dir;

            if (substr($dir, -1) != '/')
            {

                $dir .= '/';

            }

        }

        return (is_readable($dir . $template));

    }

}

?>
