<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adrian
 * Date: 4/22/13
 * Time: 10:01 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Form;

use Zend\Form\Form;


class RegisterForm extends Form {

	public function init() {

		parent::__construct('Register');

		$this->setName('Register')
			->setAttribute('method','post');

		$this->add(array(
			'name' => 'client',
			'type' => 'ClientFieldset',
			'options' => array(
				'label' => 'Client Details',
				'use_as_base_fieldset' => true
			)
		));


		$this->add(array(
			'name' => 'save',
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn-primary',
				'type' => 'submit'
			),
			'options' => array(
				'label' => 'Save',
				'twb' => array(
					'icon' => 'icon-white icon-star',
				)
			),
		));

	}

}