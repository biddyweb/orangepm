<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthenticationService
 *
 * @author samith
 */
class AuthenticationService {
    //put your code here
    private $projectDao = null;
    private $userDao = null;
    
    
    public function __construct() {
        $this->projectDao = new ProjectDao();
        $this->userDao = new UserDao();
    }
    
    /**
     *Set project Dao
     * @param ProjectDao $projectDao 
     */
    public function setProjectDao(ProjectDao $projectDao) {
        $this->projectDao =  $projectDao;
    }
    
    /**
     *Set User Dao
     * @param UserDao $userDao 
     */
    public function setUserDao(UserDao $userDao) {
        $this->userDao =  $userDao;
    }
    
    /**
     * Check whether user can or cannot edit the project's meta data
     * @param type $userId
     * @param type $projectId
     * @return boolean - true if permission is granted
     */
    public function projectAccessLevel($userId ,$projectId){
        
        $userType = User::USER_TYPE_UNSPECIFIED;
        $user = $this->userDao->getUserById($userId);
        
        if($user != null){
            $userTypeCheck = $user->getUserType();

            if($userTypeCheck== User::USER_TYPE_SUPER_ADMIN){
                return User::USER_TYPE_SUPER_ADMIN;
            }
            else
            {
                $result = $this->projectDao->getProjectUsersByProjectAndUser($userId, $projectId);
                if($result){
                    $userType = $result->getUserType();            
                    return $userType;
                }
            }
        }
        
        return $userType;
        
    }
    
    
    
    
     
     
    
    
    
   
}

?>
