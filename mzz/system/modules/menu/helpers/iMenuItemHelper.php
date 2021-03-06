<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/menu/helpers/iMenuItemHelper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: iMenuItemHelper.php 2889 2008-12-27 01:14:10Z mz $
 */

/**
 * iMenuItemHelper
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
interface iMenuItemHelper
{
    public function setArguments($item, array $args);
    public function injectItem($validator, $item = null, $smarty = null, array $args = null);
}

?>