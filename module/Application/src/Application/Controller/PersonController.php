<?php

namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;

class PersonController extends AbstractActionController {

	public function indexAction() {
		$this->redirect()->toRoute('application/default',array('controller'=>'person', 'action'=>'create'));
	}

	public function createAction() {
		$form = $this->getServiceLocator()->get('FormElementManager')->get('RegisterForm');

		$service = $this->serviceLocator->get('Application\Service\Person');

		$person = new \Application\Entity\Person();
		$form->bind($person);

		if ($this->request->isPost() && $form->setData($this->request->getPost()) && $form->isValid()) {
			$service->save($person);
			$this->flashMessenger()->addMessage('Created');
			$this->redirect()->toRoute('application/person',array('id' => $person->getId()));
		}

		return array(
			'form'=>$form
		);
	}

	public function editAction() {
		$form = $this->getServiceLocator()->get('FormElementManager')->get('RegisterForm');

		$service = $this->serviceLocator->get('Application\Service\Person');
		$person = $service->getById($this->params()->fromRoute('id'));
		$form->bind($person);

		if ($this->request->isPost() && $form->setData($this->request->getPost()) && $form->isValid()) {
			$service->save($person);
			$this->flashMessenger()->addMessage('Updated!');
			$this->redirect()->refresh();
		}

		return array(
			'form'=>$form,
			'messages' => $this->flashMessenger()->getMessages()
		);
	}


}
