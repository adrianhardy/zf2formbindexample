<?php


namespace Application\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;


class ClientFieldset extends Fieldset implements InputFilterProviderInterface {

	public function init() {

		parent::__construct('ClientFieldset');

		$this->setUseAsBaseFieldset(true);

		$this->add(array(
			'name' => 'id',
			'type' => 'hidden',
		));

		$this->add(array(
			'name' => 'firstnames',
			'type' => 'text',
			'options' => array(
				'label' => 'Firstname(s)',
			),
			'attributes' => array(
				'required' => true
			)
		));

		$this->add(array(
			'name' => 'lastname',
			'type' => 'text',
			'options' => array(
				'label' => 'Lastname',
				'twb' => array(
					// 'help-inline' => 'Don\'t forget, this is your second name'
				)
			),
			'attributes' => array(
				'required' => true
			)

		));

		$this->add(array(
			'name' => 'email',
			'type' => 'text',
			'options' => array(
				'label' => 'eMail Address'
			)
		));

		$this->add(array(
			'name' => 'dateOfBirth',
			'type' => 'date',
			'attributes' => array(
				'type' => 'text', // stop the HTML5 thing kicking in
				'data-date-format' => 'yyyy-mm-dd',
				'data-provide' => 'datepicker-inline'
			),
			'options' => array(
				'format' => 'Y-m-d',
				'label' => 'Date of Birth',
				'twb' => array(
					'append' => array(
						'type' => 'icon',
						'icon' => 'icon-calendar'
					)
				)
			)
		));


		$this->add(array(
			'name' => 'address',
			'type' => 'AddressFieldset',
			'options' => array(
				'label' => 'Address Details'
			)
		));

	}

	/**
	 * Should return an array specification compatible with
	 * {@link Zend\InputFilter\Factory::createInputFilter()}.
	 *
	 * @return array
	 */
	public function getInputFilterSpecification() {
		return array(
			'firstnames' => array(
				'required' => true
			),
			'lastname' => array(
				'required' => true
			)
		);
	}


}
