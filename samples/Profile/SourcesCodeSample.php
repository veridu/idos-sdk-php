<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../settings.php';

/**
 * For instantiating the $sdk object, responsible to call the endpoints, its necessary to create the $auth object.
 * The $auth object can instantiate the CredentialToken class, IdentityToken class, UserToken class or None class. They are related to the type of authorization required by the endpoint.
 * Passing through the CredentialToken constructor: the credential public key, handler public key and handler private key, so the auth token can be generated.
 */
$auth = new \idOS\Auth\CredentialToken(
    $credentials['credentialPublicKey'],
    $credentials['handlerPublicKey'],
    $credentials['handlerPrivKey']
);

/**
 * The proper way to call the endpoints is to statically calling the create method of the SDK class.
 * The static method create($auth) creates a new instance of the SDK class.
 */
$sdk = \idOS\SDK::create($auth);

/**
 * Creates a new source.
 * To create a new source, its necessary to call the createNew() method passing as parameter the source name, and the tags array containing the tags and its values.
 */
$response = $sdk
    ->Profile($credentials['username'])
    ->Sources->createNew(
        'email',
        [
            'otp_check' => 'email'
        ]
    );

/**
 * Checks if at least one source was created before calling other methods related to the sources endpoint that requires an existing source.
 */
if ($response['status'] === true) {
    /**
     * Stores the source id of the source created.
     */
    $sourceId = $response['data']['id'];

    /**
     * Lists all sources related to the provided username.
     */
    $response = $sdk
        ->Profile($credentials['username'])
        ->Sources->listAll();

    /**
     * Prints api call response to Sources endpoint.
     */
    echo 'List All:', PHP_EOL;
    foreach ($response['data'] as $source) {
        print_r($source);
        echo PHP_EOL;
    }

    /**
     * Updates the source created passing as parameter the stored $sourceId and the tags array containing the tags and its values.
     */
    $response = $sdk
        ->Profile($credentials['username'])
        ->Sources->updateOne(
            $sourceId,
            [
                'test'  => 'value-test',
                'other' => 'other-tag'
            ]
        );

    /**
     * Prints the api response.
     */
    echo 'Update One:', PHP_EOL;
    print_r($response['data']);
    echo PHP_EOL;

    /**
     * Retrieves information of the source created giving the stored $sourceId.
     */
    $response = $sdk
        ->Profile($credentials['username'])
        ->Sources->getOne($sourceId);

    /**
     * Prints api call response to Sources endpoint.
     */
    echo 'Get One:', PHP_EOL;
    print_r($response['data']);
    echo PHP_EOL;

    /**
     * Deletes the source retrieved passing as parameter the stored $sourceId.
     */
    $response = $sdk
        ->Profile($credentials['username'])
        ->Sources->deleteOne($sourceId);

    /**
     * Prints the status of the call response to Flags endpoint.
     */
    printf('Status: %s', $response['status']);
    echo PHP_EOL;
}
