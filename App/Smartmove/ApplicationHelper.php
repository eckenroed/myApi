<?php

namespace App\Smartmove;

/**
 * This trait will add some extra functionality to the Smartmove Property model 
 * to help it better communicate with TransUnion Servers. 
 */
trait ApplicationHelper {

    /**
     * Returns an array that can be used in a "POST" to smartmove
     * 
     * @return array
     */
    public function formatForSmartmove()
    {        
    	$attributes =  [
    		'ApplicationId' => (int) $this->smartmove_application_id ? (int) $this->smartmove_application_id : '',
            'LandlordPays' => 1,
            'PropertyId' => $this->smartmove_property_id,
            'Rent' => $this->rent ? $this->rent : $this->property->rent_amount,
            'Deposit' => $this->deposit ? $this->deposit : $this->property->deposit_amount,
            'LeaseTermInMonths' => $this->lease_term_in_months ? $this->lease_term_in_months : $this->property->lease_term,
            'UnitNumber' => '',
            'ProductBundle' => 'PackageCorePlusEviction',
    	];

        if( !$this->smartmove_application_id ) {
            $attributes['Applicants'] = [$this->applicant->email];
        }

        return $attributes;
    }

}
