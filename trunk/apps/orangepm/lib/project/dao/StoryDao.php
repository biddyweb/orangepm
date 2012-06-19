<?php
/**
 * Dao class for retrive the data of Project table
 */
class StoryDao {

    /**
	 * Save stories
	 * @param $storyParameters Array
     * return $story
	 */
    public function saveStory($storyParameters) {


        $story = new Story();

        $story->setName($storyParameters['name']);
        $story->setDateAdded($storyParameters['added date']);
        $story->setEstimation($storyParameters['estimated effort']);
        $story->setProjectId($storyParameters['project id']);
        $story->setStatus($storyParameters['status']);
        $story->setAcceptedDate($storyParameters['accepted date']);

        $story->save();
        return $story;
        
    }

    /**
	 * Selete story
	 * @param $id, $deletedDate
	 * @return none
	 */
    public function deleteStory($id, $deletedDate) {

        $story = Doctrine_Core::getTable('Story')->find($id);
        $story->setDeleted(Story::FLAG_DELETED);
        $story->setDeletedDate($deletedDate);
        $story->save();
        
    }

   /**
    * Delete story
    * @param $id, $deletedDate
    * @return none
    */
   public function getRelatedProjectStories($active, $projectId, $pageNo) {

        if ($active) {
            $pager = new sfDoctrinePager('Story', 50);
            $pager->getQuery()->from('Story a')->where('a.deleted = ?', Project::FLAG_ACTIVE)->andWhere('a.project_id = ?', $projectId)->orderBy('date_added, name');
            $pager->setPage($pageNo);
            $pager->init();
            return $pager;
        } elseif (!$active) {
            return Doctrine_Core::getTable('Story')->findAll();
        }
        
    }

   /**
    * Update story
    * @param $storyParameters Array
    * @return none
    */
    public function updateStory($storyParameters) {

        $story = Doctrine_Core::getTable('Story')->find($storyParameters['id']);
        if ($story instanceof Story) {
            $story->setName($storyParameters['name']);
            $story->setEstimation($storyParameters['estimated effort']);
            $story->setDateAdded($storyParameters['added date']);
            $story->setStatus($storyParameters['status']);
            $story->setAcceptedDate($storyParameters['accepted date']);
            $story->save();
        }
        
    }

   /**
    * Get story
    * @param $storyId
    * @return Doctrine object
    */
     public function getStory($storyId){

        return Doctrine_Core::getTable('Story')->find($storyId);
    }
    
    
    public function getTasks($storyId){
        $stroy=Doctrine_Core::getTable('Story')->find($storyId);
        return $story->getTask();
    }

    /**
    * Get stories for project progress
    * @param $active, $projectId,$sortBy
    * @return relevent Doctrine object
    */
     public function getStoriesForProjectProgress($active, $projectId,$sortBy) {

        if ($active) {
            $query = Doctrine_Core::getTable('Story')
                            ->createQuery('c')
                            ->where('c.project_id = ?', $projectId)
                            ->andWhere('c.deleted = ?', Project::FLAG_ACTIVE)
                            ->orderBy("c.{$sortBy}");
            return $query->execute();
        } elseif (!$active) {
            $query = Doctrine_Core::getTable('Story')
                            ->createQuery('c')
                            ->where('c.project_id = ?', $projectId)
                            ->orderBy("c.{$sortBy}");
            return $query->execute();
        }
    }
    
    /**
     * Get story by id
     * @param $id
     * @return Doctrine Story object
     */
    public function getStoryById($id) {

        return Doctrine_Core::getTable('Story')->find($id);
    }
    
    /**
     *
     * @param type $storyId 
     */
    public function getProjectIdByStoryId($storyId) {
        $story = Doctrine_Core::getTable('Story')->find($storyId);
        if($story!=NULL){
            return $story->getProjectId();
        }
        else{
            return NULL;
        }
    }
    
    /**
     *
     * @param type $storyId 
     */
    public function getEstimationEffortByStoryId($storyId){
        $story = Doctrine_Core::getTable('Story')->find($storyId);
        if($story != NULL)
            return $story->getEstimation();
        else 
            return NULL;
    }
    
    /*
     * @author Eranga
     * Setting estimated end date for story depending on the new task added
     */
    public function updateEstimatedEndDate($storyId,$date){
        $story=Doctrine_Core::getTable('Story')->find($storyId);
        if($story instanceof Story){
            $story->setEstimatedEndDate($date);
            $story->save();            
        }
    }

}