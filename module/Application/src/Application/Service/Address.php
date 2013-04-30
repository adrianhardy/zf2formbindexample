<?php

namespace Application\Service;

use Zend\ServiceManager\ServiceManager;

class Address {

	/**
	 * @var \Zend\Db\TableGateway\TableGateway
	 */
	protected $tg;

	/**
	 * @var \Zend\ServiceManager\ServiceManager
	 */
	protected $sm;

	public function __construct(ServiceManager $sm) {
		$this->sm = $sm;
		$this->tg = $sm->get('AddressTableGateway');
	}

	public function save(\Application\Entity\Address $address) {
		$hydrator = $this->sm->get('Application\Entity\Hydrator\Address');
		$data = $hydrator->extract($address);

		if ($address->getId()) {
			$this->tg->update($data, array('id' => $address->getId()));
		} else {
			$this->tg->insert($data);
			$address->setId($this->tg->getLastInsertValue());
		}
	}

}
