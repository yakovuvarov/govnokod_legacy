<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/block.formtag.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: block.formtag.php 3407 2009-06-24 08:07:00Z zerkms $
*/

/**
 * smarty_block_formtag: алиас-блок для вызова form::open
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_block_formtag($params, $content, $smarty)
{
    return $smarty->get_registered_object('form')->open($params, $smarty) . $content . '</form>';
}

?>
