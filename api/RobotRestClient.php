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
 
class RobotRestClient
{
  private $curl;
  private $curlOptions  = array();
  protected $httpHeader = array();
  public $baseUrl;

  /**
   * Class constructor
   * 
   * @param $url      Robot webservice url
   * @param $verbose
   */ 
  public function __construct($url, $verbose = false)
  {
    $this->baseUrl = $url;
    $this->curl = curl_init();
    $this->setCurlOption(CURLOPT_RETURNTRANSFER, true);
    $this->setCurlOption(CURLOPT_VERBOSE, $verbose);
  }

  /**
   * Class destructor
   */
  public function __destruct()
  {
    curl_close($this->curl);
  }

  /**
   * Set a curl option
   *
   * @param $option CURLOPT option constant
   * @param $value
   */
  private function setCurlOption($option, $value)
  {
    $this->curlOptions[$option] = $value;
  }

  /**
   * Get value for a curl option
   *
   * @param $option CURLOPT option constant
   * @return mixed The value
   */
  private function getCurlOption($option)
  {
    return isset($this->curlOptions[$option]) ? $this->curlOptions[$option] : null;
  }
 
  /**
   * Set a HTTP header
   * 
   * @param $name
   * @param $value
   */
  public function setHttpHeader($name, $value)
  {
    $this->httpHeader[$name] = $name . ': ' . $value;
  }
    
  /**
   * Do a GET request
   * 
   * @param $url
   * @return array Array with keys 'response_code' and 'response'
   *   On error 'response' is false
   */
  public function get($url)
  {
    $this->setCurlOption(CURLOPT_URL, $this->baseUrl . $url);
    $this->setCurlOption(CURLOPT_HTTPGET, true);
    $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'GET');

    return $this->executeRequest();
  }

  /**
   * Do a POST request
   * 
   * @param $url
   * @param $data Post data
   * @return array Array with keys 'response_code' and 'response'
   *   On error 'response' is false
   */
  public function post($url, $data = array())
  {
    $this->setCurlOption(CURLOPT_URL, $this->baseUrl . $url);
    $this->setCurlOption(CURLOPT_POST, true);
    $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'POST');
    if(isset($data))
    {
      $this->setCurlOption(CURLOPT_POSTFIELDS, http_build_query($data));
    }

    return $this->executeRequest();
  }

  /**
   * Do a PUT request
   *
   * @param $url
   * @param $data Put data
   * @return array Array with keys 'response_code' and 'response'
   *   On error 'response' is false
   */
  public function put($url, array $data = array())
  {
    $this->setCurlOption(CURLOPT_URL, $url);
    $this->setCurlOption(CURLOPT_HTTPGET, true);
    $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'PUT');
    if ($data)
    {
      $this->setCurlOption(CURLOPT_POSTFIELDS, http_build_query($data));
    }

    return $this->executeRequest();
  }

  /**
   * Do a DELETE request
   *
   * @param $url
   * @return array Array with keys 'response_code' and 'response'
   *   On error 'response' is false
   */
  public function delete($url)
  {
    $this->setCurlOption(CURLOPT_URL, $url);
    $this->setCurlOption(CURLOPT_HTTPGET, true);
    $this->setCurlOption(CURLOPT_CUSTOMREQUEST, 'DELETE');

    return $this->executeRequest();
  }
  
  /**
   * Execute HTTP request
   * 
   * @return array Array with keys 'response_code' and 'response'
   *   On error 'response' is false
   */
  private function executeRequest()
  {
    $this->setCurlOption(CURLOPT_HTTPHEADER, array_values($this->httpHeader));
    curl_setopt_array($this->curl, $this->curlOptions);
    $response = curl_exec($this->curl);

	// just response part must be json decode
    return array(
      'response_code' => curl_getinfo($this->curl, CURLINFO_HTTP_CODE),
      'response'      => json_decode($response, TRUE)
    );
  }
}
