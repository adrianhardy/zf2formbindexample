<?php


namespace Application\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;


class AddressFieldset extends Fieldset implements InputFilterProviderInterface {

	public function __construct() {

		parent::__construct('AddressFieldset');

		$this->add(array(
			'name' => 'id',
			'type' => 'hidden',
		));

		for ($i = 1; $i <= 4; $i++) {
			$this->add(array(
				'name' => 'line' . $i,
				'type' => 'text',
				'options' => array(
					'label' => 'Address Line ' . $i,
				),
				'attributes' => array(
					'required' => false
				)
			));
		}

		$this->add(array(
			'name' => 'postcode',
			'type' => 'text',
			'options' => array(
				'label' => 'Post Code',
			),
			'attributes' => array(
				'required' => true
			)
		));


	}

	/**
	 *
	 * @return array
	 * @todo make postcode adhere to a regex
	 */
	public function getInputFilterSpecification() {
		return array(
			'line1' => array(
				'required' => true,
				'validators' => array(
					'notempty' => array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Cmon, give me line 1'
							)
						)
					)
				)
			)
		);
	}


}
