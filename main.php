<?php
include_once("api/RobotRestClient.php");
include_once("api/RobotClient.php");

$robot = new RobotClient('https://api.hetzner.cloud/v1', 'PUT_YOUR_ACCESS_TOKEN_HERE');

$results = $robot->GetDatacenters('2');

if($results['response_code'] == METHOD_RETURN_CODE)
{
  print_r($results);
}
else
{
	echo 'Error ' . $results['response_code'];
}

?>
