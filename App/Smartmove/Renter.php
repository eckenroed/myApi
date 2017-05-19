<?php

namespace App\Smartmove;

use App\Smartmove\Gateway;
use App\SmartmoveApplicant;
use App\Application as RentalApplication;
use App\SmartmoveApplication;
use Carbon\Carbon;

class Renter extends Gateway {


	/**
	 * Create a new Renter API Instance
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Create or update an existing renter
	 * 
	 * @param  array  $renter
	 * @return boolean
	 */
	public function renterSave($method, array $renter)
	{		

		return $this->doRequest('RenterApi', $method, 'Renter', $renter);

		// 100111 - Renter already exists with this email address
		// 100112 - Invalid Partner Id (landlord id)
		// 100142 - The renter information does not match our records. 
		// 200015 - The renter has started IDMA. No updates allowed
	}

	/**
	 * Get the current status of the renter
	 * 
	 * @param  int    $applicationId
	 * @param  string $email
	 * @return boolean
	 */
	public function renterStatus(int $applicationId, string $email)
	{
		return $this->doRequest('RenterApi', 'GET', 'ApplicationRenterStatus', [], ['ApplicationId' => $applicationId, 'Email' => $email]);

		// 100101 - Renter info does not match, please update renter
		// 100102 - Invalid or no application id provided
		// 100103 - Renter is not associated with this application
		// 100142 - The renter information (email) does not match our records. 
	}

	/**
	 * Accept the request for a renter
	 * 
	 * @param  int    $applicationId
	 * @param  string $email
	 * @return boolean
	 */
	public function renterAccept(int $applicationId, string $email)
	{
		return $this->doRequest('RenterApi', 'PUT', 'ApplicationRenterStatus/Accept', [], ['ApplicationId' => $applicationId, 'Email' => $email]);
		
		// 100101 - Renter info does not match, please update renter
		// 100102 - Invalid or no application id provided
		// 100103 - Renter is not associated with this application
		// 100142 - The renter information (email) does not match our records. 
		// 100143 - The renter already responded to this application. 
	}

	/**
	 * Decline the request for a renter
	 * 	
	 * @param  int    $applicationId
	 * @param  string $email
	 * @return boolean
	 */
	public function renterDecline(int $applicationId, string $email)
	{
		
		return $this->doRequest('RenterApi', 'PUT', 'ApplicationRenterStatus/Decline', [], ['ApplicationId' => $applicationId, 'Email' => $email]);

		// 100101 - Renter info does not match, please update renter
		// 100102 - Invalid or no application id provided
		// 100103 - Renter is not associated with this application
		// 100142 - The renter information (email) does not match our records. 
		// 100143 - The renter already responded to this application. 
	}

	/**
	 * Get an identity verification request exam for the provided renter
	 * 
	 * @param  array  $renter
	 * @return boolean
	 */
	public function examRetrieve(array $renter)
	{
		
		return $this->doRequest('RenterApi', 'POST', 'Exam/Retrieve', $renter);

		// 100142 - The renter information (email) does not match our records. 
		// 100211 - The renter information submitted does not match the records. 
		// 200010 - Questions can not be presented to renter, please call customer service
		// 200011 - Verificaiton has already been completed, no exam is necessary
		// 200012 - The renter has exceeded the number of attempts online, pleae call customer service
		// 200013 - Unable to complete this action, please call customer service
		// 200014 - There was an unknown internal system failure, please try again
	}

	/**
	 * Evaluate the exam
	 * 
	 * @param  array  $exam
	 * @return boolean
	 */
	public function examEvaluate(array $exam)
	{
		return $this->doRequest('RenterApi', 'PUT', 'Exam/Evaluate', $exam);

		// 100142 - The renter information (email) does not match our records. 
		// 200013 - Unable to complete this action, please call customer service
		
	}

	/**
	 * Generate the report for the provided renter
	 * 
	 * @param  int    $applicationId
	 * @param  string $email
	 * @return boolean
	 */
	public function generateReports(int $applicationId, string $email)
	{
		return $this->doRequest('RenterApi', 'POST', 'Report', [], ['ApplicationId' => $applicationId, 'Email' => $email]);

		// 100102 - Invalid or no application id provided
		// 100103 - Renter is not associated with this application
		// 100142 - The renter information (email) does not match our records. 
		// 203051 - The renter has not passed IDMA yet
		// 203052 - The application is not in the correct status. 
		// 203053 - Payment has not been secured for the report
		// 203054 - Reports have already been generated, please request with Landlord API
		// 203055 - Reports have been requested and are in process of being created
		// 203056 - There was an error with the service that requests reports. Please 15 minutes
		// 203057 - There was an error with the service that requests reports. Please 15 minutes
	}
}
