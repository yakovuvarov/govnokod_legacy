<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/comments/models/commentsFolder.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsFolder.php 3665 2009-09-02 00:53:17Z striker $
*/

/**
 * commentsFolder: класс для работы с данными
 *
 * @package modules
 * @subpackage comments
 * @version 0.3.1
 */
class commentsFolder extends entity
{
    protected $object = null;
    protected $objectMapper = null;

    public function getObjectMapper()
    {
        if (is_null($this->objectMapper)) {
            $toolkit = systemToolkit::getInstance();
            $this->objectMapper = $toolkit->getMapper($this->getModule(), $this->getType());
        }

        return $this->objectMapper;
    }

    public function getObject()
    {
        if (is_null($this->object)) {
            $objectMapper = $this->getObjectMapper();
            $this->object = $objectMapper->searchOneByField($this->getByField(), $this->getParentId());
        }

        return $this->object;
    }
}
?>