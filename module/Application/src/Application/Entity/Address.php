<?php

namespace Application\Entity;

/**
 * Another plain old PHP object. Getters n setters.
 *
 * @package Application\Entity
 */
class Address {
	protected $id;

	protected $line1 = '';

	protected $line2 = '';

	protected $line3 = '';

	protected $line4 = '';

	protected $postcode = '';

	public function setLine1($line1) {
		$this->line1 = $line1;
	}

	public function getLine1() {
		return $this->line1;
	}

	public function setLine2($line2) {
		$this->line2 = $line2;
	}

	public function getLine2() {
		return $this->line2;
	}

	public function setLine3($line3) {
		$this->line3 = $line3;
	}

	public function getLine3() {
		return $this->line3;
	}

	public function setLine4($line4) {
		$this->line4 = $line4;
	}

	public function getLine4() {
		return $this->line4;
	}


	/**
	 * Parse out an array and inject the lines into the address parameters
	 * @param array $lines
	 * @return Address
	 */
	public function setLines(array $lines) {
		if (isset($lines[0])) {
			$this->setLine1($lines[0]);
		}
		if (isset($lines[1])) {
			$this->setLine2($lines[1]);
		}
		if (isset($lines[2])) {
			$this->setLine3($lines[2]);
		}
		if (isset($lines[3])) {
			$this->setLine4($lines[3]);
		}
		return $this;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setPostcode($postcode) {
		$this->postcode = $postcode;
	}

	public function getPostcode() {
		return $this->postcode;
	}



}
