<?php

/**
 * This file only returns JSON for the API calls. The actual app + HTML is in index.html.
 */

setcookie('NO_CACHE', '1');

// If not hosted on Pantheon, redirect to static data.
if (empty($_SERVER['PANTHEON_ENVIRONMENT'])) {
    header("Location: index.html#/diagram/performancelarge");
    die();
}

// Get default environment, don't use multidev.
$env = (in_array($_SERVER['PANTHEON_ENVIRONMENT'], ['dev', 'test', 'live'])) ? $_SERVER['PANTHEON_ENVIRONMENT'] : 'live';

// Redirect app to Ember diagram path
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')){
    header("Location: index.html#/diagram/" . $env);
    die();
}

/**
 * Showcase of Pantheon's abilities.
 */
header('Content-type: application/json');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$curl_result = pantheon_curl('https://api.live.getpantheon.com/sites/self/bindings', NULL, 8443);
$json_array = json_decode($curl_result['body'], true);

// Create output structure
$output = new stdClass();
$output->servers = array();

// Hard code edge servers.
// $edge = new stdClass();
// $edge->id = 'AAAAAAAA';
// $edge->type = 'edgeserver';
// $edge->endpoint = 'edge1';
// $edge->slave_of = NULL;
// $output->servers[] = $edge;

// If no environment provided in query, use current environment.
$env = isset($_GET['env']) ? $_GET['env'] : $env;

// Make a smaller JSON structure to return to the frontend.
foreach ($json_array as $key => $val) {

  // Get endpoint zone (beta).
  if (empty($output->endpoint_zone) && !empty($val['endpoint_zone'])) {
    $output->endpoint_zone = $val['endpoint_zone'];
  }

  // Make sure environment matches request.
  if ($val['environment'] == $env && !($val['type'] == 'pingdom')) {

    // Make sure it isn't a failover container.
    if (!isset($val['failover'])) {

      $type = $val['type'];
      
      // Check for Elite failover replica database.
      if (isset($val['slave_of']) && $type == "dbserver"){
        $type = "slavedbserver";
      }
      
      // Add binding data to server list.
      $binding = new stdClass();
      $binding->id = (string)substr($key, 0, 8);
      $binding->endpoint = isset($val['endpoint']) ? $val['endpoint'] : NULL;
      $binding->type = $type;
      $binding->slave_of = isset($val['slave_of']) ? $val['slave_of'] : NULL;
      $output->servers[] = $binding;
    }
  }
}

print json_encode($output);
