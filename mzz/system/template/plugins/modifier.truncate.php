<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/modifier.truncate.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: modifier.truncate.php 3048 2009-03-19 08:00:16Z striker $
*/

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function smarty_modifier_truncate($string, $length = 80, $etc = '...',
                                  $break_words = false, $middle = false)
{
    if ($length == 0)
        return '';

    if (mzz_strlen($string) > $length) {
        $length -= min($length, mzz_strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', mzz_substr($string, 0, $length+1));
        }
        if(!$middle) {
            return mzz_substr($string, 0, $length) . $etc;
        } else {
            return mzz_substr($string, 0, $length/2) . $etc . mzz_substr($string, -$length/2);
        }
    } else {
        return $string;
    }
}

/* vim: set expandtab: */

?>
