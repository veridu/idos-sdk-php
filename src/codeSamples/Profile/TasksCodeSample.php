<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../settings.php';

/**
 * Creates an auth object for a CredentialToken required in the SDK constructor for calling all endpoints. Passing through the CredentialToken constructor the credential public key, handler public and handler private key, so the auth token can be generated.
 */
$auth = new \idOS\Auth\CredentialToken(
	$credentials['credentialPublicKey'],
	$credentials['handlerPublicKey'],
	$credentials['handlerPrivKey']
);

/**
 * Valid username to be used in all /profiles endpoints.
 * @var string
 */
$username = 'f67b96dcf96b49d713a520ce9f54053c';

/**
 * Calls the create method that instantiates the SDK passing the auth object trought the constructor
 */
$sdk = \idOS\SDK::create($auth);

/**
 * Calling the Profile Class passing the username, and after that, the Processes Endpoint and the method listAll to get a random process id
 * @var [type]
 */
$response = $sdk
	->Profile($username)
    ->Processes
    ->listAll();

$processId = $response['data'][0]['id'];

/**
 * Calling the Profile Class passing the username, and after that, the Process Class passing the $processId trough the constructor. After that calls the Task Ednpoint and the method listAll
 */
$response = $sdk
	->Profile($username)
	->Process($processId)
	->Tasks
	->listAll();

/**
 * Prints the response
 */
print_r($response);
