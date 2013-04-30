<?php

namespace Application\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\TableGateway\TableGateway;

/**
 * This should be the only route into loading Person objects because of the
 * dependencies requierd for proxy objects, hydrators, etc.
 *
 * @package Application\Service
 */
class Person {

	/**
	 * @var \Zend\Db\TableGateway\TableGateway
	 */
	protected $tg;

	/**
	 * @var \Zend\ServiceManager\ServiceManager
	 */
	protected $sm;

	public function __construct(ServiceManager $sm, TableGateway $tg) {
		$this->sm = $sm;
		$this->tg = $tg;
	}

	/**
	 * Fetch a Person object by Id. The Person object will have a configured
	 * Address proxy object so that the Address object can be lazy loaded in.
	 *
	 * @param $id
	 * @return \Application\Entity\Proxy\Person
	 */
	public function getById($id) {

		// This line here won't win any awards
		$data = $this->tg->select(array('id' => $id))->current()->getArrayCopy();

		if (!empty($data)) {
			// create the empty proxy (which doesn't need to be a proxy for now)
			// because there are no overridden methods
			$person = $this->sm->get('Application\Entity\Proxy\Person');
			/** @var \Application\Entity\Hydrator\Person $hydrator */
			$hydrator = $this->sm->get('Application\Entity\Hydrator\Person');
			$hydrator->hydrate($data, $person);
		}

		return $person;
	}

	/**
	 * Use the Person Hydrator to extract the information from the Person
	 * object and then push it into a table gateway. By default, we'll also
	 * grab the address and push that through the Address Service's save
	 * method.
	 *
	 * @param \Application\Entity\Person $person
	 * @return \Application\Entity\Person
	 */
	public function save(\Application\Entity\Person $person, $cascade = true) {

		// Because MySQL hates me, FK constraints are not checked at commit,
		// they're checked mid-transaction :( So "cascade" is possible the wrong
		// word here, since we have to do it first.
		if ($cascade) {
			$service = $this->sm->get('\Application\Service\Address');
			$service->save($person->getAddress());
			$person->setAddressId($person->getAddress()->getId());
		}


		$hydrator = $this->sm->get('Application\Entity\Hydrator\Person');
		$data = $hydrator->extract($person);
		unset($data['address']); // very lazy - we need a hydrator strategy to deal with 'address'

		$this->tg->getAdapter()->getDriver()->getConnection()->beginTransaction();

		if ($person->getId()) {
			$this->tg->update($data, array('id' => $person->getId()));
		} else {
			$this->tg->insert($data);
			$person->setId($this->tg->getLastInsertValue());
		}

		$this->tg->getAdapter()->getDriver()->getConnection()->commit();

		return $person;

	}

}
