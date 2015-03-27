<?php
/**
 * Created by PhpStorm.
 * User: clops
 * Date: 26/03/2015
 * Time: 18:10
 */

namespace Clops\Domain;

use Silex\Application;

class GenericCollection implements \ArrayAccess, \IteratorAggregate, \Countable{

	/**
	 * @var Application $app
	 */
	protected $app;

	/**
	 * @var \Doctrine\DBAL\Connection $db
	 */
	protected $db;

	/**
	 * container for all collection
	 * elements
	 *
	 * @var array
	 */
	protected $elements = array();


	public function __construct( Application $app ){
		$this->app = $app;
		$this->db  = $this->app['db'];
	}

	/**
	 * does a particular key exists among the elements
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function hasKey( $key ) {
		return array_key_exists( $key, $this->elements );
	}

	/**
	 * @param mixed $key
	 * @return Generic
	 */
	public function getByKey( $key ) {
		if ( $this->hasKey( $key ) ) {
			return $this->elements[$key];
		}
		return null;
	}


	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function removeElementByKey($key) {
		if(isset($this->elements[$key])) {
			unset($this->elements[$key]);
			return true;
		}
		return false;
	}


	/**
	 * @param Generic $element
	 * @param null    $index
	 *
	 * @return bool
	 */
	public function add( Generic $element , $index=null ) {
		if ($index==null) {
			$this->elements[] = $element;
		} else {
			$this->elements[$index] = $element;
		}

		return true;
	}


	///// ***** Start Interface ArrayAccess ***** /////

	/**
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists( $index ){
		return $this->hasKey( $index );
	}

	/**
	 * @param mixed $offset
	 * @return Generic
	 */
	public function offsetGet( $index ){
		return $this->getByKey($index);
	}

	/**
	 * @param mixed $index
	 * @param Generic $domain
	 */
	public function offsetSet( $index, $domain ) {
		if ( $domain instanceof Generic )
		{
			$this->add($domain, $index);
		} else {
			throw new \Exception('Instance of Generic expected.');
		}
	}

	/**
	 * @param mixed $index
	 */
	public function offsetUnset( $index ){
		$this->removeElementByKey( $index );
	}

	///// ***** End Interface ArrayAccess ***** /////

	///// ***** Start Interface Countable ***** /////

	/**
	 * @param bool $filtered -- default: null
	 * @return int
	 */
	public function count($filtered = null) {
		if(get_class($this->getIterator()) != 'ArrayIterator' && (bool)$filtered === true) {
			$iterator = $this->getIterator();
			$position = $iterator->key();
			$count = iterator_count($iterator);
			$iterator->seek($position);

			return $count;
		}

		return count( $this->elements );
	}

	///// ***** End Interface Countable ***** /////



	///// ***** Start Interface Iterator ***** /////

	public function getIterator() {
		return new \ArrayIterator($this->elements);
	}

	///// ***** End Interface Iterator ***** /////
}