<?php

namespace Application\Entity\Proxy;

use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * This is an address proxy which extends the Address object. That means that
 * from any type checking point of view, Addresses and their Proxies are
 * interchangeable.
 *
 * The Person hydrator is responsible for injecting this proxy into the Person
 * object and making sure we have an Id to use when loading.
 *
 * Once a getter method on this proxy is called, we load in the data using the
 * TG passed in and hydrate using the hydrator passed in. If we need any funky
 * strategies during hydration, we should modify Module configuration.
 *
 * @package Application\Entity\Proxy
 */
class Address extends \Application\Entity\Address {

	protected $initialized = false;

	/** @var \Application\Entity\Proxy\TableGateway  */
	protected $tg = null;

	/** @var \Zend\Stdlib\Hydrator\HydratorInterface  */
	protected $hydrator = null;

	public function __construct(TableGateway $tg, HydratorInterface $hydrator) {
		$this->tg = $tg;
		$this->hydrator = $hydrator;
	}

	protected function ___load() {
		if (!$this->initialized) {
			$data = $this->tg->select(array('id' => parent::getId()))->current();
			if ($data) {
				$this->hydrator->hydrate($data->getArrayCopy(), $this);
				$this->initialized = true;
			}
		}
	}

	public function getLine1() {
		$this->___load();
		return parent::getLine1();
	}

	public function getLine2() {
		$this->___load();
		return parent::getLine2();
	}

	public function getLine3() {
		$this->___load();
		return parent::getLine3();
	}

	public function getLine4() {
		$this->___load();
		return parent::getLine4();
	}

	public function getPostcode() {
		$this->___load();
		return parent::getPostcode();
	}


}