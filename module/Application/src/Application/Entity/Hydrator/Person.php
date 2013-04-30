<?php

namespace Application\Entity\Hydrator;

use Application\Entity\Proxy\Address as AddressProxy;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * I'm very lazy, so I just extended ClassMethods. The pro tip from Ryan
 * Mauger (Bitterman) means that the hydrator is responsible for injecting
 * the proxy into the Person object. Without this hydrator, Person doesn't
 * really know anything about Address.
 *
 * @package Application\Entity\Hydrator
 */
class Person extends ClassMethods {

	/** @var  AddressProxy */
	protected $addressProxy;

	public function __construct($underscoreSeparatedKeys, AddressProxy $addressProxy) {
		parent::__construct($underscoreSeparatedKeys);
		$this->addressProxy = $addressProxy;
	}

	public function hydrate(array $data, $object) {
		$proxy = clone $this->addressProxy;
		$retval = parent::hydrate($data, $object);

		// admittedly, this is order sensitive because Person::setAddress()
		// overwrites Person::$addressId with Address:getId(). :(
		$proxy->setId($object->getAddressId());
		$object->setAddress($proxy);
		return $retval;
	}


}