<?php


class JobeetAffiliateTable extends Doctrine_Table
{

	public static function getInstance()
	{
		return Doctrine_Core::getTable('JobeetAffiliate');
	}

	public function countToBeActivated()
	{
		$q = $this->createQuery('a')
		->where('a.is_active = ?', 0);

		return $q->count();
	}

}