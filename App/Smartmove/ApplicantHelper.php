<?php

namespace App\Smartmove;

/**
 * This trait will add some extra functionality to the Smartmove Property model 
 * to help it better communicate with TransUnion Servers. 
 */
trait ApplicantHelper {

    /**
     * Returns an array that can be used in a "POST" to smartmove
     * 
     * @return array
     */
    public function formatForSmartmove($socialSecurityNumber = false)
    {
  

        $attributes =  [
            'Email' => $this->email,
            'MiddleName' => $this->middle_name ? $this->middle_name : $this->rentalApplication->middle_name,
            'FirstName' => $this->first_name ? $this->first_name : $this->rentalApplication->first_name,
            'LastName' => $this->last_name ? $this->last_name : $this->rentalApplication->last_name,
            'DateOfBirth' => $this->date_of_birth->format('Y-m-d') . 'T00:00:00',
            'EmploymentStatus' => $this->employment_status,            
            'HomePhoneNumber' => $this->home_phone_number,
            'OfficePhoneNumber' =>  '',
            'OfficePhoneExtension' =>  '',
            'MobilePhoneNumber' =>  '',
            'Income' => $this->income,
            'IncomeFrequency' => 'Monthly',            
            'FcraAgreementAccepted' => 1,
            'StreetAddressLineOne' => $this->street_address_line_one,
            'StreetAddressLineTwo' =>  null,
            'City' => $this->city,
            'State' => $this->state,
            'Zip' => $this->zip,                                    
            'OtherIncome' =>  0,
            'OtherIncomeFrequency' =>  'Unknown',
            'AssetValue' =>  0,
        ];

        if( $this->other_income ) {
            $attributes['OtherIncome'] = $this->other_income;
            $attributes['OtherIncomeFrequency'] = 'Monthly';
        }

        if( $this->middle_name ) $attributes['MiddleName'] = $this->middle_name;

        if( $socialSecurityNumber ) {
            $attributes['SocialSecurityNumber'] = $socialSecurityNumber;
        }

        return $attributes;
    }

    /**
     * Attempt to determine if this renter should already exist in the system
     * @return boolean
     */
    public function previousSmartmoveApplicant()
    {
        return !! static::query()
            ->where('user_id', '=', $this->user_id)
            ->where('idma_verification_status', '<>', '')
            ->whereNotNull('idma_verification_status')
            ->count();
    }

}
