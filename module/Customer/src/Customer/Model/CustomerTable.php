<?php
/**
 * Created by PhpStorm.
 * User: TriSatria
 * Date: 8/12/13
 * Time: 3:32 PM
 */

namespace Customer\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CustomerTable{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll($paginated=false)
    {
        /*
        $resultSet = $this->tableGateway->select();
        return $resultSet;*/

        if($paginated){
            $select = new Select('vela_customers');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Customer());
            $paginatorAdapter = new DbSelect(
            // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCustomer($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCustomer(Customer $cus){
        $data = array(
            'hoten' => $cus->hoten,
            'dienthoai'  => $cus->dienthoai,
            'email'  => $cus->email,
            'diachi'  => $cus->diachi,
        );

        $id = (int)$cus->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCustomer($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    public function deleteCustomer($id){
        $this->tableGateway->delete(array('id' => $id));
    }
}