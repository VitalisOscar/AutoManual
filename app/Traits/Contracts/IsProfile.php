<?php

namespace App\Traits\Contracts;

/**
 * Identifies profile types which can be used in multiple modules
 */
trait IsProfile{

    /**
     * Id of the profile
     * @return int
     */
    function getProfileId(){ return $this->id; }

    /**
     * Type of profile e.g client, admin etc
     * @return string
     */
    abstract function getProfileType();

}
