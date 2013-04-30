<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class Module implements \Zend\ModuleManager\Feature\FormElementProviderInterface {

	public function onBootstrap(MvcEvent $e) {
		$e->getApplication()->getServiceManager()->get('translator');
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getFormElementConfig() {
		return array(
			'invokables' => array(
				'RegisterFieldset' => 'Application\Form\RegisterFieldset'
			),
			'factories' => array(
				'ClientFieldset' => function (FormElementManager $sm) {
					$fs = new Form\ClientFieldset();
					$hydrator = new \Zend\Stdlib\Hydrator\ClassMethods(false);
					$hydrator->addStrategy('dateOfBirth', new \Application\Entity\Hydrator\DateHydratorStrategy());
					$fs->setHydrator($hydrator);
					$fs->setObject(new \Application\Entity\Person());
					return $fs;
				},
				'AddressFieldset' => function ($sm) {
					$fs = new Form\AddressFieldset();
					$hydrator = new \Zend\Stdlib\Hydrator\ClassMethods(false);
					$fs->setHydrator($hydrator);
					$fs->setObject(new \Application\Entity\Address());
					return $fs;
				},
				'RegisterForm' => function($sm) {
					$form = new Form\RegisterForm();
					return $form;
				}
			)
		);
	}

	public function getServiceConfig() {
		return array(
			'invokables' => array(
				'Application\Entity\Proxy\Person' => 'Application\Entity\Proxy\Person'
			),
			'factories' => array(
				'Application\Service\Person' => function ($sm) {
					return new \Application\Service\Person($sm, $sm->get('PersonTableGateway'));
				},
				'Application\Entity\Hydrator\Person' => function($sm) {
					// If Address gets its own dependent objects, then it will need its own hydrator perhaps
					$address = new Entity\Proxy\Address(
						$sm->get('AddressTableGateway'),
						$sm->get('Application\Entity\Hydrator\Address')
					);

					// The Person Hydrator is also responsible for injecting the Address proxy
					$hydrator = new Entity\Hydrator\Person(false, $address);
					// as well as dealing with Y-m-d -> DateTime conversions
					$hydrator->addStrategy('dateOfBirth', new \Application\Entity\Hydrator\DateHydratorStrategy());
					return $hydrator;
				},
				'Application\Entity\Hydrator\Address' => function ($sm) {
					return new ClassMethods(false);
				},
				'Application\Service\Address' => function ($sm) {
					$service = new \Application\Service\Address($sm);
					return $service;
				},
				'PersonTableGateway' => function ($sm) {
					return new \Zend\Db\TableGateway\TableGateway('people', $sm->get('Zend\Db\Adapter\Adapter'));
				},
				'AddressTableGateway' => function ($sm) {
					return new \Zend\Db\TableGateway\TableGateway('addresses',$sm->get('Zend\Db\Adapter\Adapter'));
				}
			)
		);
	}

}
