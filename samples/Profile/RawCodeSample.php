<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../settings.php';

/**
 * To instantiate the $sdk object, which is responsible for calling the endpoints, it is necessary to create the $auth object.
 * The $auth object can instantiate the CredentialToken class, IdentityToken class, UserToken class or None class. They relate to the type of authorization required by the endpoint.
 * Passing through the CredentialToken constructor: the credential public key, handler public key and handler private key, so the auth token can be generated.
 */
$auth = new \idOS\Auth\CredentialToken(
    $credentials['credentialPublicKey'],
    $credentials['handlerPublicKey'],
    $credentials['handlerPrivKey']
);

/**
 * The correct way to call the endpoints is by statically calling the create method of the SDK class.
 * The static create method($auth) creates a new instance of the SDK class.
 */
$sdk = \idOS\SDK::create($auth);

/**
 * To create a new raw, a source id is necessary. Before creating a new source to be used to create a new raw, all sources related to the username provided, are deleted to avoid creating a repeated feature.
 */
$sdk
    ->Profile($credentials['username'])
    ->Sources->deleteAll();

/**
 * Creates a new source to be used in the raw endpoint.
 */
$source = $sdk
    ->Profile($credentials['username'])
    ->Sources->createNew('name-test', ['tag-1' => 'value-1', 'tag-2' => 'value-2']);

/**
 * Stores the source id of the created source.
 */
$sourceId = $source['data']['id'];

/**
 * Creates a new raw.
 * To create a new raw, it is necessary to call the createNew() method passing the stored $sourceId, the collection's name, and the data array as a parameter.
 */
$rawSample1 = $sdk
    ->Profile($credentials['username'])
    ->Raw->createNew($sourceId, 'name-test-1', ['data-1' => [1, 2, 3], 'data-2' => [4, 5, 6]]);
$rawSample2 = $sdk
    ->Profile($credentials['username'])
    ->Raw->createNew($sourceId, 'name-test-2', ['data-1' => [4, 5, 6], 'data-2' => [1, 2, 3]]);

/**
 * Checks if at least one raw was created before calling other methods related to the raw endpoint (requires an existing raw).
 */
if (($rawSample1['status'] === true) || ($rawSample2['status'] === true)) {
    /**
     * Lists all raw related to the provided username.
     */
    $response = $sdk
        ->Profile($credentials['username'])
        ->Raw->listAll();

    /**
     * Prints api call response to Raw endpoint.
     */
    foreach ($response['data'] as $raw) {
        print_r($raw);
        echo PHP_EOL;
    }
}
