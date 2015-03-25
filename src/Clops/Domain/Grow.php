<?php
/**
 * Created by PhpStorm.
 * User: clops
 * Date: 25/03/2015
 * Time: 18:06
 */

namespace Clops\Domain;


class Grow extends Generic{

	protected $name;
	protected $medium;
	protected $start;
	protected $plants = Array();


	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = (string)$name;
	}


	/**
	 * @return mixed
	 */
	public function getMedium() {
		return $this->medium;
	}


	/**
	 * @param mixed $medium
	 */
	public function setMedium( $medium ) {
		$this->medium = (string)$medium;
	}


	/**
	 * @return mixed
	 */
	public function getStart() {
		return $this->start;
	}


	/**
	 * @param mixed $start
	 */
	public function setStart( $start ) {
		$this->start = $this->castToDate( $start );
	}


	public function create() {
		$this->app['db']->insert('grow', array(
			'name'    => $this->getName(), //this is the primary key, sending the same commit over WILL result in an exception :)
			'medium'  => $this->getMedium(),
			'start'   => $this->getStart(),
			'created' => $this->getCreated(),
			'company_id' => 1,
			'user_id'    => 1
		));

		$this->setID( $this->app['db']->lastInsertId() );
	}

	public function update() {

	}

}