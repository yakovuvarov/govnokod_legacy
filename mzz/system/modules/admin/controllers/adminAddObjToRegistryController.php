<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/admin/controllers/adminAddObjToRegistryController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminAddObjToRegistryController.php 3876 2009-10-22 02:40:05Z striker $
 */

fileLoader::load('forms/validators/formValidator');

/**
 * adminAddObjToRegistryController: контроллер для метода addObjToRegistryController модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2.1
 */
class adminAddObjToRegistryController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();

        $db = DB::factory();

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $classes = $adminMapper->getClasses();

        $validator = new formValidator();
        $validator->rule('required', 'class', 'Необходимо указать класс');
        $validator->rule('callback', 'class', 'Укажите существующий класс', array(
            array(
                $this,
                'checkClassExists'),
            $classes));

        if ($validator->validate()) {
            $class = $this->request->getInteger('class', SC_POST);

            $obj_id = $this->toolkit->getObjectId();
            $stmt = $db->prepare('INSERT INTO `sys_access_registry` (`obj_id`, `class_id`) VALUES (:obj_id, :section)');

            $stmt->bindValue(':obj_id', $obj_id, PDO::PARAM_INT);
            $stmt->bindValue(':section', $class, PDO::PARAM_INT);
            $stmt->execute();

            return jipTools::redirect();
        }
        $url = new url('default2');
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $action);
        $this->smarty->assign('classes', $classes);

        return $this->smarty->fetch('admin/addObjToRegistry.tpl');
    }

    function checkClassExists($id, $classes)
    {
        return array_key_exists($id, $classes);
    }
}

?>