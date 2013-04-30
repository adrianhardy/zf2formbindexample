<?php

namespace Application\Entity\Proxy;

/**
 * It seemed like a good idea at the time, but I've realised there's very little
 * need for this proxy. If we wanted, we could make Person lazy load but I don't
 * think that's sensible just yet.
 *
 * @package Application\Entity\Proxy
 */
class Person extends \Application\Entity\Person {

}