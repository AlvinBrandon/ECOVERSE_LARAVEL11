# Java Server Integration Guide for ECOVERSE

This guide explains how to integrate your existing Java server with the ECOVERSE Laravel application for vendor document verification.

## Configuration Setup

1. **Environment Variables**
   Copy the following variables to your `.env` file and update with your Java server details:
   ```
   JAVA_SERVER_URL=http://localhost:8080
   JAVA_SERVER_API_KEY=your_java_server_api_key_here
   JAVA_SERVER_TIMEOUT=60
   JAVA_SERVER_MAX_FILE_SIZE=10240
   ```

2. **Test Connection**
   Run the following command to test your Java server connection:
   ```bash
   php artisan java:test-connection
   ```

## Required Java Server Endpoints

Your Java server should implement the following REST endpoints:

### 1. Health Check Endpoint
```
GET /api/health
Response: {
  "status": "healthy",
  "version": "1.0.0",
  "timestamp": "2024-01-01T00:00:00Z"
}
```

### 2. Vendor Document Verification
```
POST /api/verify-vendor-documents
Content-Type: multipart/form-data
Authorization: Bearer {api_key}

Parameters:
- registration_certificate (file)
- ursb_document (file)
- trading_license (file)
- company_profile (file)
- additional_documents[] (files)

Response: {
  "success": true,
  "verification_id": "uuid",
  "results": {
    "registration_certificate": {
      "valid": true,
      "confidence": 0.95,
      "details": {...}
    },
    "ursb_document": {
      "valid": true,
      "confidence": 0.98,
      "details": {...}
    }
  }
}
```

### 3. URSB Specific Verification
```
POST /api/verify-ursb
Content-Type: multipart/form-data
Authorization: Bearer {api_key}

Parameters:
- ursb_document (file)
- company_details (json string, optional)

Response: {
  "success": true,
  "valid": true,
  "company_name": "...",
  "registration_number": "...",
  "registration_date": "...",
  "status": "active",
  "confidence": 0.98
}
```

### 4. Document Authenticity Check
```
POST /api/check-authenticity
Content-Type: multipart/form-data
Authorization: Bearer {api_key}

Parameters:
- document (file)

Response: {
  "success": true,
  "authentic": true,
  "confidence": 0.95,
  "security_features": [...],
  "analysis_details": {...}
}
```

### 5. Document Data Extraction
```
POST /api/extract-data
Content-Type: multipart/form-data
Authorization: Bearer {api_key}

Parameters:
- document (file)
- document_type (string, optional)

Response: {
  "success": true,
  "extracted_data": {
    "company_name": "...",
    "registration_number": "...",
    "address": "...",
    "directors": [...],
    "date_of_incorporation": "..."
  },
  "confidence": 0.92
}
```

### 6. Verification Status
```
GET /api/verification-status/{verification_id}
Authorization: Bearer {api_key}

Response: {
  "success": true,
  "verification_id": "uuid",
  "status": "completed|processing|failed",
  "progress": 100,
  "results": {...}
}
```

## Security Requirements

1. **API Authentication**
   - Use Bearer token authentication
   - Implement rate limiting
   - Validate file types and sizes

2. **File Processing**
   - Maximum file size: 10MB (configurable)
   - Supported formats: PDF, JPG, JPEG, PNG, TIFF
   - Virus scanning recommended

3. **Error Handling**
   - Return consistent JSON error responses
   - Include error codes and messages
   - Log security incidents

## Laravel Integration Points

### 1. VendorController
The vendor application submission automatically calls the Java server:
```php
// In submitApplication method
$verificationResult = $this->javaVerificationService->verifyDocuments($documents);
```

### 2. Service Class
The `JavaVendorVerificationService` handles all communication:
```php
$javaService = new JavaVendorVerificationService();
$result = $javaService->verifyDocuments($documents);
```

### 3. Middleware Protection
Add the middleware to routes that require Java server availability:
```php
Route::post('/vendor/application', [VendorController::class, 'submitApplication'])
    ->middleware('check.java.server');
```

## Testing Your Integration

1. **Connection Test**
   ```bash
   php artisan java:test-connection
   ```

2. **Document Upload Test**
   - Submit a vendor application through the web interface
   - Check Laravel logs for verification results
   - Verify Java server receives the requests

3. **Error Handling Test**
   - Stop your Java server
   - Try submitting an application
   - Verify graceful error handling

## Troubleshooting

### Common Issues

1. **Connection Timeout**
   - Check JAVA_SERVER_URL is correct
   - Increase JAVA_SERVER_TIMEOUT if needed
   - Verify Java server is running

2. **Authentication Errors**
   - Verify JAVA_SERVER_API_KEY is correct
   - Check Java server authentication implementation

3. **File Upload Errors**
   - Check file size limits (both Laravel and Java)
   - Verify supported file formats
   - Check file permissions

### Logs

Monitor the following log files:
- Laravel: `storage/logs/laravel.log`
- Java Server: Your Java application logs

## Performance Optimization

1. **Caching**
   - Server status is cached for 5 minutes
   - Consider caching verification results

2. **Async Processing**
   - For large files, consider async verification
   - Use Laravel queues for background processing

3. **Monitoring**
   - Set up health checks
   - Monitor response times
   - Track verification success rates
