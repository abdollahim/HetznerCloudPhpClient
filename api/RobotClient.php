<?php

/**
 * Client class for robot cloud webservice
 *
 * Documentation: https://robot.your-server.de/doc/webservice/en.html
 *
 * Copyright (c) 2013-2017 Hetzner Online GmbH
 *
 * Developed by Majid Abdollahi for Cloud Servers API
 */
 
class RobotClient extends RobotRestClient
{
  const VERSION = '2018.02.26';

  /**
   * Class constructor
   *
   * @param $url      Robot webservice url
   * @param $verbose
   */
  public function __construct($url, $accessToken, $verbose = false)
  {
    parent::__construct($url, $verbose);
	$this->setHttpHeader('Accept', 'application/json');
    $this->setHttpHeader('Authorization', 'Bearer ' . $accessToken);
  }

  /**
   * Execute HTTP request
   *
   * @return object Response
   *
   * @throws RobotClientException
   */
  protected function executeRequest()
  {
    $result = parent::executeRequest();

    if ($result['response'] === false)
    {
      throw new RobotClientException('robot not reachable', 'NOT_REACHABLE');
    }

    if (empty($result['response']))
    {
      $response = new StdClass();
    }
    else
    {
      $response = json_decode($result['response']);
    }

    if ($response === null)
    {
      throw new RobotClientException('response can not be decoded', 'RESPONSE_DECODE_ERROR');
    }

    if ($result['response_code'] >= 400 && $result['response_code'] <= 503)
    {
      throw new RobotClientException($response->error->message, $response->error->code);
    }

    return $response;
  }
  
  /*----------------------------------------SERVERS-------------------------------------------*/

  /**
   * Get Servers
   *
   * @param $id of server. string (optional)
   *
   * @return object server object (HTTP 200 if success)
   *
   * @throws RobotClientException
   */
  public function GetServers($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id;
	
    return $this->get($url);
  }
  
  /**
   * Create Server
   *
   * @param $name of the server to create (must be unique per project and a valid hostname as per RFC 1123) and may only contain letters, digits, periods, and dashes. string (required)
   * @param $serverType ID or name of the server type this server should be created with. string (required)
   * @param $datacenter ID or name of datacenter to create server in. string (optional)
   * @param $location ID or name of location to create server in. string (optional)
   * @param $startAfterCreate Start Server right after creation. Defaults to true. boolean (optional)
   * @param $image ID or name of the image the server is created from. string (required)
   * @param $sshKeys SSH key IDs which should be injected into the server at creation time. array (optional)
   * @param $userData Cloud-Init user data to use during server creation. This field is limited to 32KiB. string (optional)
   *
   * @return object server object (HTTP 201 if created)
   *
   * @throws RobotClientException
   */
  public function CreateServer($name, $serverType, $datacenter = null, $location = null, $startAfterCreate = true, $image, $sshKeys = null, $userData = null)
  {
    $url = '/servers';
	$data = array(
		'name' => $name,
		'server_type' => $serverType,
		'datacenter' => (isset($datacenter)) ? $datacenter : null,
		'location' => (isset($location)) ? $location : null,
		'start_after_create' => (isset($startAfterCreate)) ? $startAfterCreate : true,
		'image' => $image,
		'ssh_keys' => (isset($sshKeys)) ? $sshKeys : null,
		'user_data' => (isset($userData)) ? $userData : null
	);
	
    return $this->post($url);
  }
  
  /*----------------------------------------SERVER ACTIONS--------------------------------------*/
  
  /**
   * Power On a Server
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 201 if success)
   *
   * @throws RobotClientException
   */
  public function PowerOnServer($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id . '/actions/poweron';
	
    return $this->post($url);
  }
  
  /**
   * Soft-reboot a Server
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 201 if success)
   *
   * @throws RobotClientException
   */
  public function SoftRebootServer($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id . '/actions/reboot';
	
    return $this->post($url);
  }
  
  /**
   * Reset a Server
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 201 if success)
   *
   * @throws RobotClientException
   */
  public function ResetServer($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id . '/actions/reset';
	
    return $this->post($url);
  }
  
  /**
   * Shutdown a Server
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 201 if success)
   *
   * @throws RobotClientException
   */
  public function ShutdownServer($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id . '/actions/shutdown';
	
    return $this->post($url);
  }
  
  /**
   * Power off a Server
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 201 if success)
   *
   * @throws RobotClientException
   */
  public function PowerOffServer($id = null)
  {
    $url = '/servers';

    if(isset($id))
		$url .= '/' . $id . '/actions/poweroff';
	
    return $this->post($url);
  }
  
  /*----------------------------------------SERVER TYPES--------------------------------------*/
  
  /**
   * Get all Server Types
   *
   * @param $id of the server. string (required)
   *
   * @return object server object (HTTP 200 if success)
   *
   * @throws RobotClientException
   */
  public function GetServerTypes($id = null)
  {
    $url = '/server_types';

    if(isset($id))
		$url .= '/' . $id;
	
    return $this->get($url);
  }
  
  /*----------------------------------------LOCATIONS--------------------------------------*/
  
  /**
   * Get all Locations
   *
   * @param $id of location. string (required)
   *
   * @return object server object (HTTP 200 if success)
   *
   * @throws RobotClientException
   */
  public function GetLocations($id = null)
  {
    $url = '/locations';

    if(isset($id))
		$url .= '/' . $id;
	
    return $this->get($url);
  }
  
  /*----------------------------------------DATA CENTERS--------------------------------------*/
  
  /**
   * Get all Datacenters
   *
   * @param $id of data centers. string (required)
   *
   * @return object server object (HTTP 200 if success)
   *
   * @throws RobotClientException
   */
  public function GetDatacenters($id = null)
  {
    $url = '/datacenters';

    if(isset($id))
		$url .= '/' . $id;
	
    return $this->get($url);
  }
  
}
