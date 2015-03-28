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

	/**
	 * @var PlantCollection $plants
	 */
	protected $plants;

	/* DB Reference */
	const TABLE = 'grow';


	/**
	 * @param $id
	 * @2do     add company_id and user_id access check
	 * @return bool
	 */
	public function init($id){
		//load data from database
		if( $data = $this->db->fetchAssoc( "SELECT * FROM ".self::TABLE." WHERE grow_id = ?", array($this->getID())) ){
			$this->initFromRowData( $data );
			$this->initPlants();
			return true;
		}
		return false;
	}

	/**
	 * @param array $data
	 */
	public function initFromRowData(Array $data) {
		$this->setName( $data['name'] );
		$this->setStart( $data['start'] );
		$this->setMedium( $data['medium'] );
	}

	/**
	 *
	 */
	protected function initPlants(){
		$this->initPlantsCollection();
		$this->getPlants()->initByGrow( $this );
	}

	/**
	 * Magic Method always called after init
	 */
	protected function afterInit(){
		$this->initPlantsCollection();
	}

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


	/**
	 * @return PlantCollection
	 */
	public function getPlants() {
		return $this->plants;
	}


	/**
	 * @param PlantCollection $plants
	 */
	public function setPlants( PlantCollection $plants ) {
		$this->plants = $plants;
	}



	/**
	 * @param $number
	 */
	public function addPlants( $number ) {
		$number = (int)$number;
		if($number < 0) {
			$number = 0;
		}

		$counter = 1;
		while($counter <= $number) {
			$plant = new Plant( $this->app );
			$plant->setGrow( $this );
			$plant->setName( 'Plant '.$counter );
			$plant->setCreated('now');

			$this->plants->add($plant);
			$counter++;
		}
	}

	/**
	 * Makes sure that plants is a PlantCollection
	 */
	protected function initPlantsCollection() {
		if(!$this->plants instanceof PlantCollection){
			$this->plants = new PlantCollection( $this->app );
		}
	}


	/**
	 * @2do Implement company and user injections
	 */
	public function create() {
		//save grow
		$this->app['db']->insert(self::TABLE, array(
			'name'    => $this->getName(), //this is the primary key, sending the same commit over WILL result in an exception :)
			'medium'  => $this->getMedium(),
			'start'   => $this->getStart(),
			'created' => $this->getCreated(),
			'company_id' => 1,
			'user_id'    => 1
		));

		$this->setID( $this->app['db']->lastInsertId() );

		//save all plants in the grow
		foreach($this->getPlants() as $plant){
			$plant->create();
		}
	}

	public function update() {

	}

}