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

	public function __construct( Application $app ){
		$this->app = $app;
	}

	public function setID($id){
		$this->id = (int)$id;
	}

	public function getID(){
		return $this->id;
	}

	public function setCreated($created){
		$this->created = $this->castToDate($created);
	}

	public function getCreated(){
		return $this->created;
	}

	public function setModified($modified){
		$this->created = $this->castToDate($modified);
	}

	public function getModified(){
		return $this->created;
	}

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