<?php
/**
 * Created by PhpStorm.
 * User: clops
 * Date: 26/03/2015
 * Time: 18:19
 */

namespace Clops\Domain;


class Plant extends Generic{

	protected $grow;
	protected $name;

	/* DB Reference */
	const TABLE = 'plant';

	/**
	 * @param $id
	 */
	public function init($id){
		//load data from database

	}


	/**
	 * @return Grow
	 */
	public function getGrow() {
		return $this->grow;
	}


	/**
	 * @param Grow $grow
	 */
	public function setGrow( Grow $grow ) {
		$this->grow = $grow;
	}


	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = (string)$name;
	}




	public function create() {
		//save grow
		$this->app['db']->insert(self::TABLE, array(
			'name'    => $this->getName(), //this is the primary key, sending the same commit over WILL result in an exception :)
			'created' => $this->getCreated(),
			'grow_id' => $this->getGrow()->getID()
		));

		$this->setID( $this->app['db']->lastInsertId() );
	}


	public function update() {

	}

}