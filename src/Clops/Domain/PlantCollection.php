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
	 * @2do add company_id and user_id filters
	 */
	public function initByGrow( Grow $grow ){
		$data = $this->db->fetchAll( "SELECT * FROM plant WHERE grow_id = ?", array( $grow->getID() ));
		foreach($data as $item){
			$plant = new Plant( $this->app );
			$plant->initFromRowData( $item );
			$plant->setGrow( $grow );
			$this->add( $plant, $plant->getID() );
		}
	}
}