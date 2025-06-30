<?php

namespace App\Services;

use GuzzleHttp\Client;

class JavaVendorVerificationService
{
    protected $client;
    protected $javaServerUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->javaServerUrl = env('JAVA_SERVER_URL', 'http://localhost:8080/api/verify-ursb');
    }

    /**
     * Send vendor data to Java server for URSB verification
     *
     * @param string $ursbDocument
     * @param string $email
     * @param string $name
     * @return array
     */
    public function verifyUrsb($ursbDocument, $email, $name)
    {
        $response = $this->client->post($this->javaServerUrl, [
            'json' => [
                'ursbDocument' => $ursbDocument,
                'email' => $email,
                'name' => $name,
            ],
            'http_errors' => false,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
} 