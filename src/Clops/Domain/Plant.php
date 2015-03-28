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
	protected $height;

	/* DB Reference */
	const TABLE = 'plant';

	/**
	 * @param $id
	 */
	public function init($id){
		//load data from database
		if( $data = $this->db->fetchAssoc( "SELECT * FROM ".self::TABLE." WHERE plant_id = ?", array($this->getID())) ){
			$this->initFromRowData( $data );
			return true;
		}
		return false;
	}


	/**
	 * @param array $data
	 */
	public function initFromRowData(Array $data) {
		$this->setID( $data['plant_id'] );
		$this->setName( $data['name'] );
		$this->setHeight( $data['height'], false );
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


	/**
	 * @return int
	 */
	public function getHeight () {
		return $this->height;
	}


	/**
	 * @param mixed $height
	 */
	public function setHeight ( $height, $trackHistory=true ) {
		if($this->height && $height != $this->height && $trackHistory){
			$this->createHistorySnapshot();
		}
		$this->height = (int)$height;
	}


	/**
	 * Take a not of the older plant height for future reference
	 */
	protected function createHistorySnapshot() {
		//save grow
		$this->db->insert('plant_history', array(
			'plant_id' => $this->getID(),
			'height'   => $this->getHeight(),
			'created'  => $this->castToDate('now')
		));
	}


	/**
	 *
	 */
	public function create() {
		//save grow
		$this->db->insert(self::TABLE, array(
			'name'    => $this->getName(), //this is the primary key, sending the same commit over WILL result in an exception :)
			'created' => $this->getCreated(),
			'grow_id' => $this->getGrow()->getID()
		));

		$this->setID( $this->app['db']->lastInsertId() );
	}


	/**
	 * @return int
	 */
	public function update() {
		return $this->db->update(self::TABLE, array(
													'name'     => $this->getName(),
		                                            'height'   => $this->getHeight()
												), array(
													'plant_id' => $this->getID(),
												    'grow_id'  => $this->getGrow()->getID()
												));

	}

}