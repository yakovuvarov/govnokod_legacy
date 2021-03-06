<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/filters/userFilter.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id: userFilter.php 3585 2009-08-06 05:56:01Z striker $
*/

/**
 * userFilter: фильтр для инициализации текущего пользователя
 *
 * @package system
 * @subpackage filters
 * @version 0.1.2
 */
class userFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();

        $userMapper = $toolkit->getMapper('user', 'user');
        $user_id = $toolkit->getSession()->get('user_id');

        $user = null;

        if (is_null($user_id)) {
            $userAuthMapper = $toolkit->getMapper('user', 'userAuth');
            $hash = $request->getString(userAuthMapper::AUTH_COOKIE_NAME, SC_COOKIE);
            $ip = $request->getServer('REMOTE_ADDR');
            $userAuth = $userAuthMapper->getAuth($hash, $ip);

            // если пользователь сохранил авторизацию, тогда восстанавливаем её
            if (!is_null($userAuth)) {
                $user = $userAuth->getUser();
            }

            if ($user) {
                $userMapper->updateLastLoginTime($user);
            }

        } else {
            $user = $userMapper->searchByKey($user_id);
        }

        $toolkit->setUser($user);

        $filter_chain->next();
    }
}

?>