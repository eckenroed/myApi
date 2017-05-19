<?php

namespace App\Smartmove;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ErrorException;
use App\SmartmoveLog;
use App\Smartmove\GatewayError;

class Gateway {

	 /**
     * Smartmove Partner ID
     * @var int
     */
    protected $partnerId;

    /**
     * Smartmove Shared Secret Key
     * 
     * @var string
     */
    protected $sharedSecretKey;

    /**
     * The API URL
     * 
     * @var string
     */
    protected $apiUrl;

    /**
     * The API to use (LandlordApi or RenterApi)
     * 
     * @var string
     */
    protected $apiName;

    /**
     * The version of the API this class works with
     * 
     * @var string
     */
    protected $apiVersion = 'v2';

    /**
     * The Class that is requesting this transmission
     * 
     * @var string
     */
    protected $smartmoveable_type;

    /**
     * The id of the class that is requesting this transmission
     * 
     * @var int
     */
    protected $smartmoveable_id;

    /**
     * The Body of the response. On Errors this is set to false
     * 
     * @var array
     */
    protected $response;

    /**
     * Holds the numeric response code. 
     * 
     * @var int
     */
    protected $responseCode;

    /**
     * The headers to be used on the request
     * 
     * @var array
     */
    protected $headers = [];

    /**
     * The guzzle Client that will be used
     * 
     * @var [type]
     */
    protected $client;

    /**
     * Stores any errors returned from TRUSS
     * 
     * @var array
     */
    protected $error;

    /**
     * Smartmove Log
     * 
     * @var App\SmartmoveLog
     */
    protected $log;

    /**
     * The Method used when making the request
     * 
     * @var string
     */
    protected $request_method;

    /**
     * The API used when  making the request
     * 
     * @var string
     */
    protected $request_api;

    /**
     * The function called when making the request
     * 
     * @var string
     */
    protected $request_functionName;

    /**
     * The data posted or put when making the request
     * 
     * @var array
     */
    protected $request_data;

    /**
     * The data used to build the query string if needed for the request
     * 
     * @var array
     */
    protected $request_queryString;

    /**
     * The ID of the record the request is trying to access
     * 
     * @var integer
     */
    protected $request_id;

    protected $responseHeaders;

     /**
     * Class Constructor
     *
     * @param null $env Which environment should be set?
     */
    public function __construct()
    {
    	$this->sandbox(); // Calculate if we are using the Sandbox or not
        $this->setCredentials(env('SMARTMOVE_PARTNER_ID'), env('SMARTMOVE_SHARED_SECRET_KEY'));
    	$this->client = new Client($this->guzzleConfig());        
    }

    /**
     * Magic Getter, allow read-only access to a handful of attributes
     * 
     * @param  string $attribute The attribute to get
     * @return mixed            
     */
    public function __get($attribute)
    {
        $allowed = ['response', 'error', 'log'];

        if( in_array($attribute, $allowed) ) return $this->$attribute;
    }

    /**
     * Set the Sandbox approprirately and return the object back.
     * @param  boolean $sandbox [description]
     * @return [type]           [description]
     */
    public function sandbox()
    {
    	if( env('APP_ENV') == 'production' ) :
    		$this->apiUrl = 'https://mysmgateway.com/';
    	else : 
    	 	$this->apiUrl = 'https://smlegacygateway-integration.mysmartmove.com/';
    	 endif;	

    	return $this;
    }

    public function setCredentials(int $partnerId, string $sharedSecretKey)
    {
    	$this->partnerId = $partnerId;
    	$this->sharedSecretKey = $sharedSecretKey;

    	return $this;
    }

     public function guzzleConfig()
    {
        return [];
        // Currently this function only compiles the headers portion of the options. But if more custom config
        // options are needed at a later time, then this can be modified to inject those as well.
        
        $this->headers['Content-Type'] = 'application/json; charset=utf-8';
        
        $data = [];
        if( $this->headers ) {
            $data['headers'] = $this->headers;
        } 

        $data['verify'] = false;

        return $data;
    }

    /**
     * Create the Security Token that must be included in the header of ever request
     *
     * @param string $serverTime
     * @return string
     */
    public function _securityToken($serverTime)
    {
        //create the HashKey
        $publicKey = $this->partnerId . $serverTime;

        // extra step to insure the sharedSecretKey is encoded in UTF8
        $sharedSecretKey = mb_convert_encoding($this->sharedSecretKey, "UTF8");

        // hashes the public key and private key together with SHA1
        return mb_convert_encoding(hash_hmac('sha1', $publicKey, $sharedSecretKey, true), 'BASE64');
    }

    /**
     * Create the headers to be included with each request
     *
     * @param string $api The API to call
     * @return array
     */
    public function _buildOptions()
    {
        // Build the raw output options first        
        $output['verify'] = false;
        if( strtoupper($this->request_method) == 'PUT' || strtoupper($this->request_method) == 'POST') {
            $output['json'] = $this->request_data;
        }

        

        // Build the headers section
        $headers['Content-Type'] = 'application/json; charset=utf-8';
    
        // Get the server time
        $url = $this->apiUrl . "{$this->apiName}/{$this->apiVersion}/ServerTime";        
        $response = $this->client->get($url);
        $serverTime = json_decode($response->getBody()->getContents());
        $serverTime = substr($serverTime, 0, strpos($serverTime, '.'));

        $headers['Authorization'] = "smartmovepartner partnerId=\"{$this->partnerId}\", serverTime=\"{$serverTime}\", securityToken=\"{$this->_securityToken($serverTime)}\"";

        // Add the headers to the options
        $output['headers'] = $headers;

        $this->options = $output;
        return $output;
    }

    /**
     * Perform a request to the Smartmove Service
     * @param string $apiName       The API to use (LandlordApi or RenterApi)
     * @param  string $method       PUT, POST or GET
     * @param  string $functionName The name of the function on the API to be called
     * @param  array  $data         The data for PUT and POST
     * @param  array  $queryString  The data for GET
     * @param  int $id           The ID of a record for GET requests
     * @return void
     */
    public function doRequest($api, $method, $functionName, $data = [], $queryString = [], $id = null)
    {
        $this->request_api = $api;
        $this->apiName = $api;
        $this->request_method = $method;
        $this->request_functionName = $functionName;
        $this->request_data = $data;
        $this->request_queryString = $queryString;
        $this->request_id = $id;

        return $this->_processRequest();
    }

    /**
     * Process the request
     * @return bool Whether or not the requested was succesful or not
     */ 
    protected function _processRequest() {

        // Construct the Full URL as needed for the request
        $this->_buildFullUrl();                

        // Create the Security Header Authorization String
        $this->_buildOptions();
        
        // Attempt to gain a response
        try {
            $response = $this->client->request($this->request_method, $this->request_url . $this->_buildQueryString(), $this->options);
        } catch( ClientException $e ) {
            $this->_processErrorResponse($e);
            return $this->responseOk();            
        } catch( \Exception $e) {
            $this->_processHttpResponseError($e);
            return $this->responseOk();
        }

        // Process the response
        $this->_processResponse($response);
        return $this->responseOk();
    }

    /**
     * Build the Query string to be appended to the request URL
     *
     * @param array $data
     * @return string
     */
    private function _buildQueryString()
    {
        if( empty($this->request_queryString) ) return '';

        $this->queryString = '?' . http_build_query($this->request_queryString, '&');

        return $this->queryString;
    }

    /**
     * Build the full URL
     *
     * @param string $api
     * @param string $functionName
     * @param bool|false $id
     * @return string
     */
    private function _buildFullUrl()
    {

        $this->request_url = $this->url = 
            $this->apiUrl . "{$this->request_api}/{$this->apiVersion}/{$this->request_functionName}" . 
            (empty($this->request_id) ? '' : "/{$this->request_id}/");

    }

    /**
     * Process an Http Error Response
     * @param  \Exception $e 
     */
    protected function _processHttpResponseError($e)
    {        
        $this->response = ['Errors' => $e->getMessage()];
        $this->responseCode = $e->getCode();
        $this->responseHeaders = $e->getResponse()->getHeaders();


        $this->log = SmartmoveLog::create([
            'headers'                => $e->getRequest()->getHeaders(),
            'method'                => $this->request_method,
            'smartmoveable_type'    => $this->smartmoveable_type,
            'smartmoveable_id'      => $this->smartmoveable_id,
            'url'                   => $this->url,
            'query_string'          => !empty($this->queryString) ? $this->_buildQueryString() : '',
            'body'                  => $this->request_data  ? $this->request_data : NULL,
            'response_body'         => $this->response,
            'response_code'         => $this->responseCode,
            'response_headers'      => $this->responseHeaders,
            'is_resolved'           => 0,
        ]);
    }

    /**
     * Process the error received from an attempt and Log it. 
     * 
     * @param  mixed $e Either a ClientException or a Standard Exception
     */
    protected function _processErrorResponse($e)
    {   
        $responseText = is_string($e->getResponse()->getBody()) ? $e->getResponse()->getBody() : $e->getResponse()->getBody()->getContents();
        
        // We are only dealing with ClientExceptions here
        if( $e->getCode() != 409) {
            return $this->_processHttpResponseError($e);
        }        
        //$pattern = '/\{"Errors":\[.*/';
        $pattern = '/\{.*\}/';
        preg_match($pattern, $responseText, $result);        
        
        $this->response = json_encode($result[0]);        
        $this->responseCode = $e->getCode();
        $this->responseHeaders = $e->getResponse()->getHeaders();

        $this->log = SmartmoveLog::create([
            'headers'                => $e->getRequest()->getHeaders(),
            'method'                => $this->request_method,
            'smartmoveable_type'    => $this->smartmoveable_type,
            'smartmoveable_id'      => $this->smartmoveable_id,
            'url'                   => $this->url,
            'query_string'          => !empty($this->queryString) ? $this->_buildQueryString() : '',
            'body'                  => $this->request_data  ? $this->request_data : NULL,
            'response_body'         => $this->response,
            'response_code'         => $this->responseCode,
            'response_headers'      => $this->responseHeaders,
            'is_resolved'           => 0,
        ]);
    }

    /**
     * Take a succesful Call and Log it into the Logs
     * 
     * @param  \Guzzle\Psr7\Response $response 
     */
    protected function _processResponse($response)
    {   
        // Get and decode the body to an array                 
        $body = remove_utf8_bom($response->getBody()->getContents());
        $this->response = json_decode($body, true);
        $this->responseCode = $response->getStatusCode();
        $this->responseHeaders = $response->getHeaders();        

        $this->log = SmartmoveLog::create([
            'headers'                => $this->options['headers'],
            'method'                => $this->request_method,
            'smartmoveable_type'    => $this->smartmoveable_type,
            'smartmoveable_id'      => $this->smartmoveable_id,
            'url'                   => $this->url,
            'query_string'          => !empty($this->queryString) ? $this->_buildQueryString() : '',
            'body'                  => $this->request_data  ? $this->request_data : NULL,
            'response_body'         => $this->response,
            'response_code'         => $this->responseCode,
            'response_headers'      => $this->responseHeaders,
        ]);
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

    /**
     * Return the HTTP response code from the last request.
     *
     * @return int
     */
    public function responseCode()
    {
        return $this->responseCode;
    }

    /**
     * Return whether or not the request was succesful
     * 
     * @return boolean 
     */
    public function responseOk()
    {
        return $this->responseCode >= 200 && $this->responseCode <= 299;
    }

    public function error()
    {
        if( $this->responseOk() ) return false;

        return new GatewayError($this->request_method, $this->responseCode, $this->response);
    }
	
}