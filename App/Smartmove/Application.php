<?php

namespace App\Smartmove;

use App\SmartmoveApplication; 
use App\SmartmoveApplicant;
use App\Application as RentalApplication;
use App\Helpers\SmartmoveSync;


class Application extends Gateway {	

	/**
	 * The Express Rentals Application to rent
	 * @var \App\Application
	 */
	protected $rentalApplication;

	/**
	 * The Local copy of the Smartmove Application 
	 * @var \App\SmartmoveApplication
	 */
	protected $smartmoveApplication;



	/**
	 * Create a new Application Instance
	 * @param mixed $application The application to load 
	 */
	public function __construct($application)
	{
		parent::__construct();

		if( is_object($application) ) $this->_loadFromLocal($application);
		if( is_array($application) ) $this->_loadFromSmartmove($application);
		if( is_string($application) || is_int($application) ) $this->_loadFromSartmoveId();		
	}

	protected function _loadFromLocal(RentalApplication $application)
	{
		$this->rentalApplication = $application;

		/**
		 * If a Smartmove Application already exists for the provided
		 * application, load it. 
		 */
		if( $application->smartmoveApplication ) :
			$this->smartmoveApplication = $application->smartmoveApplication;
		endif;
	}

	protected function _loadFromSmartmove(array $smartmoveApplication)
	{
		
	}

	protected function _loadFromSmartmoveId($id)
	{
		$this->smartmoveApplication = SmartmoveApplication::query()->where('application_id', '=', $id)->get()->first();
		$this->rentalApplication = $this->smartmoveApplication->rentalApplication;

	}


	/**
	 * Saves the Application with the smartmove servers
	 * @return [type] [description]
	 */
	public function saveApplication()
	{		
		if( $this->smartmoveApplication ) :
			return $this->saveExistingApplication();
		else :
			return $this->saveNewApplication();
		endif;	
	}

	/**
	 * Saves a first time application to the system
	 * @return boolean 
	 */
	public function saveNewApplication()
	{	
		$data = [
			'ApplicationId'		=> '', // Must be blank when creating a new 
			'LandlordPays'		=> true,
			'PropertyId'		=> $this->rentalApplication->property->smartmoveProperty->smartmove_property_id,
			'Rent'				=> $this->rentalApplication->listing->rent_amount,
			'Deposit'			=> $this->rentalApplication->listing->deposit_amount,
			'LeaseTermInMonths'	=> $this->rentalApplication->listing->term,
			'UnitNumber'		=> '',
			'ProductBundle' 	=> 'PackageCore',
			'Applicants' 		=> [ $this->rentalApplication->user->email ],
		];
		
		/**
		 * Since there is no "SmartmoveApplication" to link this call
		 * to, we'll instead link it to App\Application for the 
		 * purpose of logging the transaction. 
		 */		
		$this->smartmoveable('\App\Application', $this->rentalApplication->id);
		
		if ( !$this->post($data) ) return false;

		$this->persist();

		return true;
	
	}

	public function saveExistingApplication()
	{
		# code...
	}

	/**
	 * Persist an application to the database.
	 */
	public function persist()
	{
		if( $this->smartmoveApplication ) :

		endif;
		// Createing a new application
		$this->smartmoveApplication = SmartmoveApplication::create([
			'smartmove_application_id' => $this->response['ApplicationId'],
			'status' => null,
			'er_application_id' => $this->rentalApplication->id,
			'er_property_id' => $this->rentalApplication->property->id,
			'landlord_id' => $this->rentalApplication->property->landlordable->id,
			'landlord_pays' => $this->response['LandlordPays'],
			'rent' => $this->response['Rent'],
			'deposit' => $this->response['Deposit'],
			'lease_term_in_months' => $this->response['LeaseTermInMonths'],
			'unit_number' => null,
			'product_bundle' => $this->response['ProductBundle'],
			'credit_recommendation' => null,
			'credit_recommendation_policy_text' => null,
			'initiated_by' => $this->rentalApplication->initiated_by,
			'initiated_by_id' => $this->rentalApplication->initiated_by == 'renter' ? 
				$this->rentalApplication->user_id : $this->rentalApplication->property->landlordable->id,
			'conditional_rent' => null,
			'conditional_deposit' => null,
			'conditional_lease_term' => null,
			'conditional_notes' => null,
			'progress' => 'created',
		]);

		// Update the sync item
		$this->smartmoveApplication->sync->inSync()->lastSync(time());
		$this->smartmoveApplication->save();
	}


	/**
	 * Assign the Model and ID for Breadcrum in the Log
	 * @param  string $type 
	 * @param  int $id   
	 */
	public function smartmoveable($type, $id)
	{
		$this->smartmoveable_type = $type;
		$this->smartmoveable_id = $id;

		return $this;
	}

	public function get($applicationId = false)
	{
		return $this->doRequest('LandlordApi', 'GET', 'Application', [], [], $applicationId);
	}

	public function post($data)
	{

		return $this->doRequest('LandlordApi', 'POST', 'Application', $data);
	}

	public function put($data)
	{
		return $this->doRequest('LandlordApi', 'PUT', 'Application', $data);
	}

	public function cancel($applicationId)
	{
		return $this->doRequest('LandlordApi', 'PUT', 'Application/Cancel', [], [], $applicationId);
	}

}
