<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JavaVendorVerificationService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;
    protected $timeout;
    protected $maxFileSize;
    protected $supportedFormats;
    protected $endpoints;
    protected $retryAttempts;
    protected $retryDelay;

    public function __construct()
    {
        $config = config('java_server');
        
        $this->baseUrl = $config['url'];
        $this->apiKey = $config['api_key'];
        $this->timeout = $config['timeout'];
        $this->maxFileSize = $config['max_file_size'];
        $this->supportedFormats = $config['supported_formats'];
        $this->endpoints = $config['endpoints'];
        $this->retryAttempts = $config['retry_attempts'];
        $this->retryDelay = $config['retry_delay'];
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ]
        ]);
    }

    /**
     * Verify all vendor documents with Java server
     *
     * @param array $documents
     * @param string $email
     * @param string $name
     * @return array
     */
    public function verifyDocuments($documents, $email, $name)
    {
        try {
            $multipart = [
                [
                    'name' => 'email',
                    'contents' => $email
                ],
                [
                    'name' => 'name',
                    'contents' => $name
                ],
                [
                    'name' => 'verification_type',
                    'contents' => 'vendor_application'
                ]
            ];

            // Add each document file to the multipart request
            foreach ($documents as $documentType => $filePath) {
                if (!empty($filePath) && Storage::disk('public')->exists($filePath)) {
                    $fullPath = Storage::disk('public')->path($filePath);
                    $multipart[] = [
                        'name' => $documentType,
                        'contents' => fopen($fullPath, 'r'),
                        'filename' => basename($filePath)
                    ];
                }
            }

            $headers = [];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->post($this->javaServerUrl . '/api/verify-vendor-documents', [
                'multipart' => $multipart,
                'headers' => $headers,
                'timeout' => $this->timeout,
                'http_errors' => false,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200) {
                Log::info('Java server document verification successful', [
                    'email' => $email,
                    'response' => $responseData
                ]);

                return [
                    'status' => 'success',
                    'data' => $responseData,
                    'verification_score' => $responseData['verification_score'] ?? 0,
                    'document_statuses' => $responseData['document_statuses'] ?? [],
                    'risk_flags' => $responseData['risk_flags'] ?? [],
                    'recommendations' => $responseData['recommendations'] ?? []
                ];
            } else {
                Log::error('Java server returned error', [
                    'status_code' => $response->getStatusCode(),
                    'response' => $responseData
                ]);

                return [
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Document verification failed',
                    'error_code' => $responseData['error_code'] ?? 'UNKNOWN_ERROR'
                ];
            }

        } catch (RequestException $e) {
            Log::error('Java server connection failed', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return [
                'status' => 'error',
                'message' => 'Failed to connect to verification service',
                'error_code' => 'CONNECTION_ERROR'
            ];
        } catch (\Exception $e) {
            Log::error('Unexpected error during document verification', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return [
                'status' => 'error',
                'message' => 'Unexpected error during verification',
                'error_code' => 'UNEXPECTED_ERROR'
            ];
        }
    }

    /**
     * Send vendor data to Java server for URSB verification (legacy method)
     *
     * @param string $ursbDocument
     * @param string $email
     * @param string $name
     * @return array
     */
    public function verifyUrsb($ursbDocument, $email, $name)
    {
        try {
            $headers = [];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->post($this->javaServerUrl . '/api/verify-ursb', [
                'json' => [
                    'ursbDocument' => $ursbDocument,
                    'email' => $email,
                    'name' => $name,
                ],
                'headers' => $headers,
                'timeout' => $this->timeout,
                'http_errors' => false,
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (RequestException $e) {
            Log::error('URSB verification failed', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return [
                'status' => 'error',
                'message' => 'URSB verification service unavailable'
            ];
        }
    }

    /**
     * Check document authenticity with Java server
     *
     * @param string $filePath
     * @param string $documentType
     * @return array
     */
    public function checkDocumentAuthenticity($filePath, $documentType)
    {
        try {
            if (!Storage::disk('public')->exists($filePath)) {
                return [
                    'status' => 'error',
                    'message' => 'Document file not found'
                ];
            }

            $fullPath = Storage::disk('public')->path($filePath);
            $headers = [];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->post($this->javaServerUrl . '/api/check-authenticity', [
                'multipart' => [
                    [
                        'name' => 'document',
                        'contents' => fopen($fullPath, 'r'),
                        'filename' => basename($filePath)
                    ],
                    [
                        'name' => 'document_type',
                        'contents' => $documentType
                    ]
                ],
                'headers' => $headers,
                'timeout' => $this->timeout,
                'http_errors' => false,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            return [
                'status' => $response->getStatusCode() === 200 ? 'success' : 'error',
                'is_authentic' => $responseData['is_authentic'] ?? false,
                'confidence_score' => $responseData['confidence_score'] ?? 0,
                'fraud_indicators' => $responseData['fraud_indicators'] ?? []
            ];

        } catch (RequestException $e) {
            Log::error('Document authenticity check failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath
            ]);

            return [
                'status' => 'error',
                'message' => 'Authenticity check service unavailable'
            ];
        }
    }

    /**
     * Extract data from document using Java server OCR
     *
     * @param string $filePath
     * @param string $documentType
     * @return array
     */
    public function extractDocumentData($filePath, $documentType)
    {
        try {
            if (!Storage::disk('public')->exists($filePath)) {
                return [
                    'status' => 'error',
                    'message' => 'Document file not found'
                ];
            }

            $fullPath = Storage::disk('public')->path($filePath);
            $headers = [];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->post($this->javaServerUrl . '/api/extract-data', [
                'multipart' => [
                    [
                        'name' => 'document',
                        'contents' => fopen($fullPath, 'r'),
                        'filename' => basename($filePath)
                    ],
                    [
                        'name' => 'document_type',
                        'contents' => $documentType
                    ],
                    [
                        'name' => 'extraction_mode',
                        'contents' => 'comprehensive'
                    ]
                ],
                'headers' => $headers,
                'timeout' => $this->timeout,
                'http_errors' => false,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            return [
                'status' => $response->getStatusCode() === 200 ? 'success' : 'error',
                'extracted_text' => $responseData['extracted_text'] ?? '',
                'structured_data' => $responseData['structured_data'] ?? [],
                'confidence_score' => $responseData['confidence_score'] ?? 0
            ];

        } catch (RequestException $e) {
            Log::error('Document data extraction failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath
            ]);

            return [
                'status' => 'error',
                'message' => 'Data extraction service unavailable'
            ];
        }
    }

    /**
     * Get verification status from Java server
     *
     * @param string $verificationId
     * @return array
     */
    public function getVerificationStatus($verificationId)
    {
        try {
            $headers = [];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer ' . $this->apiKey;
            }

            $response = $this->client->get($this->javaServerUrl . '/api/verification-status/' . $verificationId, [
                'headers' => $headers,
                'timeout' => 30,
                'http_errors' => false,
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (RequestException $e) {
            Log::error('Failed to get verification status', [
                'error' => $e->getMessage(),
                'verification_id' => $verificationId
            ]);

            return [
                'status' => 'error',
                'message' => 'Status check service unavailable'
            ];
        }
    }
} 