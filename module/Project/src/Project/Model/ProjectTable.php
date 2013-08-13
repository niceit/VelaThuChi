<?php
/**
 * Created by PhpStorm.
 * User: TriSatria
 * Date: 8/13/13
 * Time: 2:20 PM
 */
namespace Project\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProjectTable {
    protected $tableGateway;
    public function  __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll($paginated=false){
        if($paginated){
            $select = new Select('vela_projects');
            //create location save query resault
            $resultSetPrototype = new ResultSet();
            //type of location
            $resultSetPrototype->setArrayObjectPrototype(new Project());
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
        return $this->tableGateway->select();
    }
    public function saveProject(Project $project){
        $data = array(
            'customer_id' => $project->customer_id,
            'project_name'  => $project->project_name,
            'project_descriptions'  => $project->project_descriptions,
        );

        $id = (int)$project->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProject($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }
    public function deleteProject($id){
        $this->tableGateway->delete(array('id' => $id));
    }
    public function getProject($id){
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}