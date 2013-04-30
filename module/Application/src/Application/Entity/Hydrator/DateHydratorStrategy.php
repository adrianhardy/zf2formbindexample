<?php

namespace Application\Entity\Hydrator;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateHydratorStrategy implements StrategyInterface {

	public function extract($value) {
		if ($value instanceof \DateTime) {
			return $value->format('Y-m-d');
		}
		return $value;
	}

	public function hydrate($value) {
		return \DateTime::createFromFormat('Y-m-d',$value);

	}


}