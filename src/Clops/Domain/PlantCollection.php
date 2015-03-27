<?php
/**
 * Created by PhpStorm.
 * User: clops
 * Date: 26/03/2015
 * Time: 18:20
 */

namespace Clops\Domain;


class PlantCollection extends GenericCollection{

	/**
	 * @param Grow $grow
	 */
	public function initByGrow( Grow $grow ){
		$data = $this->db->fetchAll( "SELECT * FROM plant WHERE grow_id = ?", array( $grow->getID() ));
		foreach($data as $item){
			$plant = new Plant( $this->app );
			$plant->setID( $item['plant_id'] );
			$plant->setName( $item['name'] );
			$this->add( $plant );
		}
	}
}