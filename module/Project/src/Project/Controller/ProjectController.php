<?php
namespace Project\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Project\Model\ProjectTable;
use Project\Model\Project;
use Zend\View\Model\ViewModel;
use Project\Form\ProjectForm;

class ProjectController extends AbstractActionController
{
    protected  $projectTable;
    public function init(){
        $this->layout('adminLayout');
    }
    public function indexAction()
    {
        $this->layout('adminLayout');
        $paginator = $this->getProjectTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);
        return new ViewModel(array(
            'project_list' => $paginator
        ));
    }

    public function addAction()
    {
        $form = new ProjectForm();
        $this->layout('adminLayout');
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if($request->isPost()){
            $project = new Project();
            $form->setInputFilter($project->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $project->exchangeArray($form->getData());
                $this->getProjectTable()->saveProject($project);
                return $this->redirect()->toRoute('project');
            }
        }
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function editAction()
    {
        $this->layout('adminLayout');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('project', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $pro = $this->getProjectTable()->getProject($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('project', array(
                'action' => 'index'
            ));
        }

        $form  = new ProjectForm();
        $form->bind($pro);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($pro->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProjectTable()->saveCustomer($pro);

                // Redirect to list of albums
                return $this->redirect()->toRoute('project');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('project');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProjectTable()->deleteProject($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('project');
        }

        return array(
            'id'    => $id,
            'project' => $this->getProjectTable()->getProject($id)
        );
    }

    public function getProjectTable()
    {
        if (!$this->projectTable) {
            $sm = $this->getServiceLocator();
            $this->projectTable = $sm->get('Project\Model\ProjectTable');
        }
        return $this->projectTable;
    }
}