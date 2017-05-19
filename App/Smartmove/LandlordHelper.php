<?php 
namespace App\Smartmove;

trait LandlordHelper {

	/**
	 * Return an array that can be provided as part of a Property object
	 * @return array 
	 */
	public function formatForSmartmove()
	{
		return [
			'FirstName' => $this->firstName(),
			'LastName' => $this->lastName(),
			'StreetAddressLineOne' => $this->primaryAddress->delivery_line_1,
			//'StreetAddressLineTwo',
			'City' => $this->primaryAddress->city_name,
			'State' => $this->primaryAddress->state_abbreviation,
			'Zip' => $this->primaryAddress->zipcode,
			'PhoneNumber' => $this->primaryPhoneNumber->number,
			'Email' => $this->email,
		];
	}
}
