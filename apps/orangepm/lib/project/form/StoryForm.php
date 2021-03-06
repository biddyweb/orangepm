<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of storyForm
 *
 * @author orangehrm
 */
class storyForm extends sfForm {

   /**
	 * Configure story form
	 *
	 */
    
    private $projectId;
    
    public function configure() {

        
       $this->projectId = $this->getOption('projectId');
       $projectMembers = $this->_getProjectMembers();
        
        $this->setWidgets(array(
            'storyName' => new sfWidgetFormInputText(),
            'dateAdded' => new sfWidgetFormInputText(),
            'estimatedEffort' => new sfWidgetFormInputText(),
            'projectId' => new sfWidgetFormInputHidden(),
            'assignTo' => new sfWidgetFormSelect(array('choices' => $projectMembers)), 
            'status' => new sfWidgetFormSelect(array('choices' => array(0 => 'Backlog', 1 => 'Design', 2 => 'Development', 3 => 'Development Completed', 4 => 'Testing',  5 => 'Rework', 6 => 'Accepted'))),
            'acceptedDate' => new sfWidgetFormInputText(),
        ));

        $this->setDefault('dateAdded', date('Y-m-d'));
        //$this->setDefault('acceptedDate', date('Y-m-d'));


        $this->widgetSchema->setNameFormat('project[%s]');
        $this->widgetSchema['storyName']->setAttribute('size' , 60);
        $this->widgetSchema->setLabel('storyName', 'Story Name'."<span class='mandatoryStar'>*</span>");
        $this->widgetSchema->setLabel('dateAdded', 'Date Added');
        $this->widgetSchema->setLabel('estimatedEffort', 'Estimated Effort');
        $this->widgetSchema->setLabel('assignTo', 'Assign To');
        $this->widgetSchema->setLabel('status', 'Status');
        $this->widgetSchema->setLabel('acceptedDate', 'Accepted Date');

        $this->setValidators(array(
            'storyName' => new sfValidatorString(array(),array('required' => __('Enter Story Name'))),
            'dateAdded' => new sfValidatorDate(array(),array('required' => __('Enter Date Added'))),
            'estimatedEffort' => new sfValidatorNumber(array('required' =>false)),
            'assignTo' => new sfValidatorString(array('required' =>false)),
            'status' => new sfValidatorString(array('required' =>false)),
            'projectId' => new sfValidatorString(),
            'acceptedDate' => new sfValidatorDate(array('required' =>false)),
        ));
        }
        
        private function _getProjectMembers() {
        
        $list = array();
         
         $this->projectDao = new ProjectDao();
         $this->userDao = new UserDao();
         $users = $this->projectDao->getUsersByProjectId($this->projectId);
         
        foreach ($users as $user) {
            
            $userName = $this->userDao->getUserById($user->getUserId());
            $list[$user->getUserId()] = $userName->getFirstName().' '.$userName->getLastName();;
                
         } 
        
        return $list;
        
        
    }

    

}

