<?php

namespace Application\Entity;

use Application\Entity\Address;

/**
 * A very simple object which could, if required, carry more domain logic.
 * Intentioanlly, this object knows nothing about how to persist itself and
 * moreover, it has no idea how to fetch the dependent "Address" object.
 *
 * That's the responsibility of the proxy and the hydrators.
 *
 * @see \Application\Entity\Hydrator\Person
 * @see \Application\Entity\Proxy\Address
 *
 * @package Application\Entity
 */
class Person {

	protected $id;

	protected $firstnames = '';

	protected $lastname = '';

	protected $dateOfBirth;

	protected $email = '';

	protected $address;

	protected $addressId;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getAddressId() {
		return $this->addressId;
	}

	public function setAddressId($addressId) {
		$this->addressId = $addressId;
	}

	public function getAddress() {
		if (!$this->address) {
			$this->setAddress(new Address());
		}
		return $this->address;
	}

	public function setAddress(Address $address) {
		$this->setAddressId($address->getId());
		$this->address = $address;
		return $this;
	}

	public function setDateOfBirth(\DateTime $dateOfBirth) {
		$this->dateOfBirth = $dateOfBirth;
		return $this;
	}

	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}

	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setFirstnames($firstnames) {
		$this->firstnames = $firstnames;
		return $this;
	}

	public function getFirstnames() {
		return $this->firstnames;
	}

	public function setLastname($lastname) {
		$this->lastname = $lastname;
		return $this;
	}

	public function getLastname() {
		return $this->lastname;
	}

}
