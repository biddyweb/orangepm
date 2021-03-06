<?php

class editTaskAction extends sfAction {

    public function preExecute(){
        if ((!$this->getUser()->isAuthenticated()) && ($this->getRequestParameter('action') != 'login' )) {
            echo 'notSaved';
            exit;
        }
        $this->taskService = new TaskService();
    }
    public function execute($request) {
        $projectId = $request->getParameter('projectId');
        $loggedUserObject = null;
        $auth = new AuthenticationService();
        
        $projectAccessLevel = $auth->projectAccessLevel($this->getUser()->getAttribute($loggedUserObject)->getId(), $projectId);
        if ($projectAccessLevel == User::USER_TYPE_PROJECT_ADMIN || $projectAccessLevel == User::USER_TYPE_SUPER_ADMIN || $projectAccessLevel == User::USER_TYPE_PROJECT_MEMBER) {
            $task = new Task();
            $task->setId($request->getParameter('id'));
            $task->setName($request->getParameter('name'));
            $task->setEffort($request->getParameter('effort') ? $request->getParameter('effort') : 'NULL');
            $task->setEstimatedEndDate($request->getParameter('estimatedEndDate'));
            $task->setStatus($request->getParameter('status'));
            $task->setDescription($request->getParameter('description'));
            $task->setOwnedBy($request->getParameter('ownedBy'));
            $this->taskService->updateTask($task);            
            die;
        }else {
            $this->redirect("project/viewProjects");
        }
    }
}