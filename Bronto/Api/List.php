<?php

/** @var Bronto_Api_List_Row */
require_once 'Bronto/Api/List/Row.php';

/** @var Bronto_Api_List_Exception */
require_once 'Bronto/Api/List/Exception.php';

class Bronto_Api_List extends Bronto_Api_Abstract
{
    /**
     * The object name.
     *
     * @var string
     */
    protected $_name = 'Lists';
    
    /**
     * @var string
     */
    protected $_rowClass = 'Bronto_Api_List_Row';
    
    /**
     * Classname for exceptions
     *
     * @var string
     */
    protected $_exceptionClass = 'Bronto_Api_List_Exception';
    
    /**
     * @param array $filter
     * @param int $pageNumber
     * @return Bronto_Api_Rowset
     */
    public function readAll(array $filter = array(), $pageNumber = 1)
    {
        $params = array();
        $params['filter']     = $filter;
        $params['pageNumber'] = (int) $pageNumber;
        return parent::readAll($params);
    }
    
    /**
     * @param array $data
     * @return Bronto_Api_List_Row
     */
    public function createRow(array $data = array())
    {
        return parent::createRow($data);
    }
    
    /**
     * @param array $data
     * @return bool
     */
    public function clear(array $data = array())
    {
        if (!isset($data[0])) {
            $data = array($data);
        }
        $client   = $this->getApi()->getSoapClient();
        $result   = $client->clearLists($data)->return;
        $row      = array_shift($result->results);

        if (isset($result->errors) && $result->errors) {
            $exceptionClass = $this->getExceptionClass();
            throw new $exceptionClass($row->errorString, $row->errorCode);
        }
        
        return true;
    }
}