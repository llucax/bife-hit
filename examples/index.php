<?
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
// | Created: mié jun 18 01:05:57 ART 2003                              |
// | Authors: Leandro Lucarella <luca@lugmen.org.ar>                    |
// +--------------------------------------------------------------------+
//
// $Id$
//

// This is a simple test and example of HTML_Template_HIT

ini_set('include_path', '../src:'.ini_get('include_path'));
umask('002');

require_once 'HTML/Template/HIT.php';

$hit =& new HTML_Template_HIT('hooks');

for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 20; $j++) {
        $hit->parseBuffered('cell', 'CELL', "$i,$j");
    }
    $hit->parseBuffered('row', 'ROW', $hit->popBuffer('cell'));
}
echo $hit->parse(
    'body',
    array(
        'ROWS' => $hit->popBuffer('row'),
        'TITLE' => 'HOLA MUNDO!!!',
    )
);

?>
