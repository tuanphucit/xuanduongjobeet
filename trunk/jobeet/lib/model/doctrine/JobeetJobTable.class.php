<?php


// lib/model/doctrine/JobeetJobTable.class.php
class JobeetJobTable extends Doctrine_Table
{
  static public $type = array(
   'full-time' => 'Full time',
   'part-time' => 'Part time',
   'freelance' => 'Freelance',
  );
  
  public function getTypes(){
  	return self::$type;
  }
  
  public function retrieveActiveJob(Doctrine_Query $q)
  {
    return $this->addActiveJobsQuery($q)->fetchOne();
  }
 
  public function getActiveJobs(Doctrine_Query $q = null)
  {
    return $this->addActiveJobsQuery($q)->execute();
  }
 
  public function countActiveJobs(Doctrine_Query $q = null)
  {
    return $this->addActiveJobsQuery($q)->count();
  }
 
  public function addActiveJobsQuery(Doctrine_Query $q = null)
  {
    if (is_null($q))
    {
      $q = Doctrine_Query::create()
        ->from('JobeetJob j');
    }
 
    $alias = $q->getRootAlias();
 
    $q->andWhere($alias . '.expires_at > ?', date('Y-m-d H:i:s', time()))
      ->addOrderBy($alias . '.created_at DESC');
      
    $q->andWhere($alias . '.is_activated = ?', 1);
 
    return $q;
  }
  
  public function retrieveBackendJobList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
 
    $q->leftJoin($rootAlias . '.JobeetCategory c');
 
    return $q;
  }
}