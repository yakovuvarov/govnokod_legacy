<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/function.title.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: function.title.php 2605 2008-10-11 15:33:01Z mz $
*/

/**
 * smarty_function_title: функция для Smarty, сборка заголовка страницы
 *
 * Примеры использования:<br />
 * <code>
 * {title append="Новости" separator=" - "}
 * {title append="2007"}
 * {title append="Список"}
 * {title separator=" | "} // Новости - 2007 | Список
 * {title separator=" | " end=" - "}
 * {title separator=" | " start=" - "}
 * </code>
 *
 * Значения аргументов end или start присоединяются к результату только
 * при выводе заголовка и если он не пустой (одно из применений: разделитель
 * для названия сайта и цепочки заголовков)
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string|void заголовок если не указан параметр append
 * @package system
 * @subpackage template
 * @version 0.1.1
 */
function smarty_function_title($params, $smarty)
{
    static $titles = array();
    if (isset($params['append'])) {
        /*if (i18n::isName($params['append'])) {
            $params['append'] = smarty_prefilter_i18n('{' . $params['append'] . '}', $smarty);
        }*/

        $titles[] = array($params['append'], isset($params['separator']) ? $params['separator'] : false);
    } else {
        $title = '';
        $separator = '';
        foreach ($titles as $t) {
            if (!is_null($t[0]) && $t[0] != '') {
                $separator = ($t[1] === false) ? (isset($params['separator']) ? $params['separator'] : '') : $t[1];
                $title .= $t[0] . $separator;
            }
        }
        $title = substr($title, 0, -(strlen($separator)));

        if (isset($params['end']) && !empty($title)) {
            $title .= $params['end'];
        }
        if (isset($params['start']) && !empty($title)) {
            $title = $params['start'] . $title;
        }
        return $title;
    }
}

?>