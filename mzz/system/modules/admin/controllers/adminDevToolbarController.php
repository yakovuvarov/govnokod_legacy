<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/admin/controllers/adminDevToolbarController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminDevToolbarController.php 3966 2009-11-13 04:30:49Z striker $
 */

/**
 * adminDevToolbarController: контроллер для метода devToolbar модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminDevToolbarController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $modules = $adminMapper->getModules();

        $hiddenClasses = array_flip(explode(',', $this->request->getString('mzz-devToolbarH', SC_COOKIE)));

        $this->smarty->assign('modules', $modules);
        $this->smarty->assign('hiddenClasses', $hiddenClasses);
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>