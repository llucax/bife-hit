<?php
// vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
// +--------------------------------------------------------------------+
// |                       BIFE - Buil It FastEr                        |
// +--------------------------------------------------------------------+
// | This file is part of BIFE.                                         |
// |                                                                    |
// | BIFE is free software; you can redistribute it and/or modify it    |
// | under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or  |
// | (at your option) any later version.                                |
// |                                                                    |
// | BIFE is distributed in the hope that it will be useful, but        |
// | WITHOUT ANY WARRANTY; without even the implied warranty of         |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU   |
// | General Public License for more details.                           |
// |                                                                    |
// | You should have received a copy of the GNU General Public License  |
// | along with Hooks; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA      |
// +--------------------------------------------------------------------+
// | Created: Wed Jun 17 19:03:14 2003                                  |
// | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
// +--------------------------------------------------------------------+
//
// $Id$
//

// +X2C Class 130 :HIT
/**
 * Hooks vs IT Template Engine.
Hooks vs IT (HIT) is a simple template implementation, based on hooks and IT template systems.
 *
 * @package HTML_Template
 * @access public
 */
class HTML_Template_HIT {
    /**
     * Root directory where template files are.
     *
     * @var    string $root
     * @access public
     */
    var $root = '.';

    /**
     * If it's true, it looks for template files in PHP's include_path.
     *
     * @var    bool $useIncludePath
     * @access public
     */
    var $useIncludePath = false;

    /**
     * Group of templates to use (a subdirectory in root).
     *
     * @var    string $group
     * @access protected
     */
    var $group = '';

    /**
     * Templates cache.
     *
     * @var    array $cache
     * @access protected
     */
    var $cache = array();

    /**
     * Parsed templates buffer.
     *
     * @var    array $buffer
     * @access protected
     */
    var $buffer = array();

    // ~X2C

    // +X2C Operation 136
    /**
     * Constructor.
     *
     * @param  string $root Root directory where template files are.
     * @param  bool $useIncludePath If it's true, it looks for template files in PHP's include_path.
     * @param  string $group Group of templates to use (a subdirectory in root).
     *
     * @return void
     * @access public
     */
    function HTML_Template_HIT($root = '.', $useIncludePath = false, $group = '') // ~X2C
    {
        $this->__construct($root, $useIncludePath, $group);
    }
    // -X2C

    // +X2C Operation 137
    /**
     * Constructor.
     *
     * @param  int $root Root directory where template files are.
     * @param  false $useIncludePath If it's true, it looks for template files in PHP's include_path.
     * @param  string $group Group of templates to use (a subdirectory in root).
     *
     * @return void
     * @access public
     */
    function __construct($root = '.', $useIncludePath = false, $group = '') // ~X2C
    {
        $this->root = $root;
        $this->useIncludePath = $useIncludePath;
        $this->pushGroup($group);
    }
    // -X2C

    // +X2C Operation 138
    /**
     * Parse a template returning the results.
If $vars is an array, the {[keys]} are replaced with [values] ($val is ignored). If is a string, {$vars} is replaced with $val.
     *
     * @param  string $name Name of template to parse.
     * @param  mixed $vars Variables to replace in the template.
     * @param  string $val If $vars is a string, the value to replace for $vars.
     * @param  mixed $group Group to use to parse this template. Null to use the current group.
     *
     * @return string
     * @access public
     */
    function parse($name, $vars = '', $val = '', $group = null) // ~X2C
    {
        $group = is_null($group) ? end($this->group) : $group;
        if ($group) {
            $file = "{$this->root}/$group/$name.tpl.html";
        } else {
            $file = "{$this->root}/$name.tpl.html";
        }
        if (!isset($this->cache[$file])) {
            // FIXME - replace join(file()) with file_get_contents().
            $this->cache[$file] = join('', file($file, $this->useIncludePath));
        }
        if ($vars) {
            if (is_string($vars)) {
                $vars = array($vars => $val);
            }
            foreach ($vars as $key => $val) {
                $keys[] = '{' . $key . '}';
                $vals[] = $val;
            }
            return str_replace($keys, $vals, $this->cache[$file]);
        } else {
            return $this->cache[$file];
        }
    }
    // -X2C

    // +X2C Operation 144
    /**
     * Parse a template adding the results to the buffer.
Parse a template appending the results to an internal buffer. If $vars is an array, the {[keys]} are replaced with [values] ($val is ignored). If is a string, {$vars} is replaced with $val.
     *
     * @param  string $name Name of template to parse.
     * @param  mixed $vars Variables to replace in the template.
     * @param  string $val If $vars is a string, the value to replace for $vars.
     *
     * @return void
     * @access public
     */
    function parseBuffered($name, $vars = '', $val = '') // ~X2C
    {
        @$this->buffer["{$this->group}/$name"] .= $this->parse($name, $vars, $val);
    }
    // -X2C

    // +X2C Operation 145
    /**
     * Gets a parsed buffer.
     *
     * @param  string $name Name of the parsed template to get.
     *
     * @return string
     * @access public
     */
    function getBuffer($name) // ~X2C
    {
        return @$this->buffer["{$this->group}/$name"];
    }
    // -X2C

    // +X2C Operation 146
    /**
     * Gets a parsed buffer and removes it.
     *
     * @param  string $name Name of the buffer to flush.
     *
     * @return void
     * @access public
     */
    function popBuffer($name) // ~X2C
    {
        $return = @$this->buffer["{$this->group}/$name"];
        unset($this->buffer["{$this->group}/$name"]);
        return $return;
    }
    // -X2C

    // +X2C Operation 139
    /**
     * Sets the group to use and add it to the groups stack.
     *
     * @param  string $group Group to use.
     *
     * @return void
     * @access public
     */
    function pushGroup($group = '') // ~X2C
    {
        $this->group[] = $group;
    }
    // -X2C

    // +X2C Operation 140
    /**
     * Removes the group from the groups stack and returns to the previous used group.
     *
     * @return string
     * @access public
     */
    function popGroup() // ~X2C
    {
        return array_pop($this->group);
    }
    // -X2C

    // +X2C Operation 159
    /**
     * Tells if a template exists.
True if the template $name exists in $group (or the current group).
     *
     * @param  string $name Name of the template.
     * @param  mixed $group Template's group. If it's null it uses the current group.
     *
     * @return bool
     * @access public
     */
    function exists($name, $group = null) // ~X2C
    {
        $group = is_null($group) ? end($this->group) : $group;
        if ($group) {
            $file = "{$this->root}/$group/$name.tpl.html";
        } else {
            $file = "{$this->root}/$name.tpl.html";
        }
        if (!$this->useIncludePath) {
            return is_readable($file);
        } else {
            $include_path = array_unique(preg_split('/[:;]/', ini_get('include_path')));
            foreach ($include_path as $path) {
                if (is_readable("$path/$file")) {
                    return true;
                }
            }
            return false;
        }
    }
    // -X2C

} // -X2C Class :HIT

?>