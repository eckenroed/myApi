<?php

namespace App\Smartmove;

use App\Smartmove\Gateway;
use App\Smartmove\Property;

/**
 * This class represents a smartmove landlord that goes with the 
 * landlord object in the new API (v2)
 */
class Landlord extends Gateway {


	/**
	 * Create a new Landlord API Instance
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Retrieves Property Information. 
	 * 
	 * @param  integer $propertyId The TURSS Assigned Property Id
	 * @return boolean	True/False based on success
	 */
	public function propertyGet(int $propertyId)
	{
		return $this->doRequest('LanldordApi', 'GET', 'Property', [], [],$propertyId);
		
		// Possible Error Codes
		// 203058 or 203059, fatal property does not exist
	}

	/**
	 * Create or Save a property
	 * 
	 * @param  array  $property The property object
	 * @return boolean  Indication of success
	 */
	public function propertySave(array $property)
	{	
		// PUT if propertyId exists, otherwise it's a POSt
		$method = array_key_exists('PropertyId', $property) && !empty($property['PropertyId']) ? 'PUT' : 'POST';



		return $this->doRequest('LandlordApi', $method, 'Property', $property);

		// Possible Error Codes
		// 203058 or 203059 - PUT only, fatal property does not exist
	}

	/**
	 * Get an application from the TURSS service
	 * 
	 * @param  int    $applicationId The TURSS Assigned ID
	 * @return boolean                True/False based on success
	 */
	public function applicationGet(int $applicationId)
	{
		return $this->doRequest('LandlordApi', 'GET', 'Application', [], [], $applicationId);
		
		// 203061 - PUT, The Application ID could not be found
		// 203062 - PUT, The Application ID could not be found
	}

	/**
	 * Create or Update an application with the TURSS service
	 * 
	 * @param  array  $application The Application Object
	 * @return boolean              True/False based on success
	 */
	public function applicationSave(array $application)
	{
		$method = array_key_exists('ApplicationId', $application) && !empty($application['ApplicationId']) ? 'PUT' : 'POST';
		
		
		return  $this->doRequest('LandlordApi', $method, 'Application', $application);

		
		// 203060 - POST, An application ID was provided when trying to create, it should be blank
		// 203063 - POST, The Property used is inactive. Please activate it first
		// 203061 - PUT, The Application ID could not be found
		// 203062 - PUT, The Application ID could not be found
	}

	/**
	 * Cancel an entire application 
	 * 
	 * @param  int    $applicationId The TURSS assigned Application Id
	 * @return boolean
	 */
	public function applicationCancel(int $applicationId)
	{
		return $this->doRequest('LandlordApi', 'PUT', 'Application/Cancel/' . $applicationId);
		
		// 203064 - There was an unknown error trying to cancel
	}

	/**
	 * Get the status of the Applicant
	 * 
	 * @param  int    $applicationId
	 * @param  string $email
	 * @return boolean
	 */
	public function applicantStatus(int $applicationId, string $email)
	{
		return $this->doRequest('LandlordApi', 'GET', 'Applicant/Status', [], ['ApplicationId' => $applicationId, 'Email' => $email]);
	}

	/**
	 * Add a new applicant to an existing application
	 * 
	 * @param  int    $applicationId 
	 * @param  string $email
	 * @return boolean
	 */
	public function applicantAdd(int $applicationId, string $email)
	{
		return $this->doRequest('LandlordApi', 'POST', 'Applicant/Add', ['ApplicationId' => $applicationId, 'Email' => $email]);
	}

	/**
	 * Remove an applicant from an existing application
	 * 
	 * @param  int    $applicationId 
	 * @param  string $email
	 * @return boolean
	 */
	public function applicantDelete(int $applicationId, string $email)
	{
		return $this->doRequest('LandlordApi', 'PUT', 'Applicant/Delete', ['ApplicationId' => $applicationId, 'Email' => $email]);
	}

}
