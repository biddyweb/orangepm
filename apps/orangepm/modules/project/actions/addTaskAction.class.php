<?php

class addTaskAction extends sfAction {
        private $userName;
    public function preExecute() {
        if ((!$this->getUser()->isAuthenticated()) && ($this->getRequestParameter('action') != 'login' )) {
            $this->redirect('project/login');
        }
        $this->storyDao = new StoryDao();
        $this->projectService =  new ProjectService();
        $this->taskService =  new TaskService();
    }
    public function execute($request) {
        $this->storyId = $request->getParameter('storyId');
        $this->story = $this->storyDao->getStoryById($this->storyId);
        $this->project = $this->projectService->getProjectById($this->story->getProjectId());
        $loggedUserObject = null;
        $auth = new AuthenticationService();
        $projectAccessLevel = $auth->projectAccessLevel($this->getUser()->getAttribute($loggedUserObject)->getId(), $this->story->getProjectId());
        if ( $projectAccessLevel == User::USER_TYPE_PROJECT_ADMIN || $projectAccessLevel == User::USER_TYPE_SUPER_ADMIN || $projectAccessLevel == User::USER_TYPE_PROJECT_MEMBER) {
            $this->taskForm = new TaskForm(array(),array('projectId' => $this->story->getProjectId()));            
            $this->taskList = $this->taskService->getTaskByStoryId($this->storyId);
            if ($request->isMethod('post')) {
                $this->taskForm->bind($request->getParameter('task'));
                if ($this->taskForm->isValid()) {
                    $userDao =  new UserDao();
                    $user = $userDao->getUserById($this->taskForm->getValue('ownedBy'));
                    $this->userName = $user->getFirstName().' '.$user->getLastName();
                    $this->saveTask();
                    $this->redirect("project/viewTasks?storyId={$this->storyId}");
                }
            }
            else{
                $this->taskForm->setDefault('estimatedEndDate', date("Y-m-d"));
            }
        } else {
            $this->redirect("project/viewProjects");
        }
    }
    
    public function saveTask() {
        $task = new Task();
        $task->setName($this->taskForm->getValue('name'));
        $task->setEffort($this->taskForm->getValue('effort') ? $this->taskForm->getValue('effort') : null);
        $task->setEstimatedEndDate($this->taskForm->getValue('estimatedEndDate'));
        $task->setStatus($this->taskForm->getValue('status'));
        $task->setOwnedBy($this->userName);
        $task->setDescription($this->taskForm->getValue('description'));
        $task->setStoryId($this->storyId);
        $this->taskService->saveTask($task);
    }
}