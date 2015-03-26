<?php
/**
 * Created by PhpStorm.
 * User: clops
 * Date: 25/03/2015
 * Time: 18:07
 */

namespace Clops\Domain;

use Silex\Application;

abstract class Generic {

	protected $app;
	protected $id;
	protected $created;
	protected $modified;
	protected $user;
	protected $company;

	const TABLE = 'generic';


	/**
	 * @param Application $app
	 * @param null        $id
	 */
	public function __construct( Application $app, $id = null ){
		$this->app = $app;

		$this->beforeInit();
		if(isset($id)){
			$this->init($id);
		}
		$this->afterInit();
	}

	protected function beforeInit(){

	}

	protected function afterInit(){

	}


	/**
	 * @param $id
	 *
	 * @return bool
	 */
	abstract public function init( $id );


	/**
	 * @param $id
	 */
	public function setID($id){
		$this->id = (int)$id;
	}


	/**
	 * @return mixed
	 */
	public function getID(){
		return $this->id;
	}


	/**
	 * @param $created
	 */
	public function setCreated($created){
		$this->created = $this->castToDate($created);
	}


	/**
	 * @return mixed
	 */
	public function getCreated(){
		return $this->created;
	}


	/**
	 * @param $modified
	 */
	public function setModified($modified){
		$this->created = $this->castToDate($modified);
	}


	/**
	 * @return string
	 */
	public function getModified(){
		return $this->created;
	}


	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}


	/**
	 * @param User $user
	 */
	public function setUser( User $user ) {
		$this->user = $user;
	}


	/**
	 * @return Company
	 */
	public function getCompany() {
		return $this->company;
	}


	/**
	 * @param mixed $company
	 */
	public function setCompany( Company $company ) {
		$this->company = $company;
	}


	/**
	 * @param $date
	 *
	 * @return string
	 */
	protected function castToDate($date){
		return date('Y-m-d H:i:s', strtotime($date));
	}


	abstract public function create();
	abstract public function update();

	public function save(){
		if($this->getID()){
			$this->update();
		} else {
			$this->create();
		}
		return $this->getID();
	}
}