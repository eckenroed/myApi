<?php

namespace App\Smartmove;

class SmartmoveProperty extends Gateway {

	/**
	 * The Smartmove Property Model that is being used
	 * @var App\SmartmoveProperty
	 */
	protected $smartmovePropertyModel;

	/**
	 * An Array/object that mirrors what the Smartmove API is expecting to receive
	 * @var json
	 */
	protected $smartmovePropertyObject;

	public function __construct()
	{
		parent::__construct();
	}

	public static function boot()
	{
		// When a property is created we need to make sure 
		// we create a finger print as well as sync it to 
		// smartmove.
		static::creating(function($property){
			$this->fingerprint = strtolower(str_random(25));
		});
	}

	public function smartmoveable($type, $id)
	{
		$this->smartmoveable_type = $type;
		$this->smartmoveable_id = $id;

		return $this;
	}

	public function get($id = false)
	{
		return $this->doRequest('LandlordApi', 'GET', 'Property', [], [], $id);
	}

	public function post($data)
	{

		return $this->doRequest('LandlordApi', 'POST', 'Property', $data);
	}

	public function put($data)
	{
		return $this->doRequest('LandlordApi', 'PUT', 'Property', $data);
	}
}