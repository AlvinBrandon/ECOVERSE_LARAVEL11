@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Vendor Application Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Java Server Response Message Styling */
  .java-response-message {
    display: none;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: none;
    position: relative;
    overflow: hidden;
  }

  .java-response-message::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #10b981, #3b82f6);
    background-size: 200% 100%;
    animation: gradient-flow 3s ease-in-out infinite;
  }

  @keyframes gradient-flow {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }

  .java-response-message.success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-left: 5px solid #10b981;
  }

  .java-response-message.error {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border-left: 5px solid #ef4444;
  }

  .java-response-message.pending {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-left: 5px solid #f59e0b;
  }

  .response-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
  }

  .response-icon {
    font-size: 1.5rem;
    padding: 0.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .response-icon.success {
    background: #10b981;
    color: white;
  }

  .response-icon.error {
    background: #ef4444;
    color: white;
  }

  .response-icon.pending {
    background: #f59e0b;
    color: white;
  }

  .response-title {
    font-weight: 600;
    font-size: 1.125rem;
    margin: 0;
  }

  .response-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
    margin: 0;
  }

  .response-content {
    margin-bottom: 0.75rem;
  }

  .response-message {
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 0.5rem;
  }

  .response-additional-info {
    font-size: 0.875rem;
    color: #6b7280;
    font-style: italic;
  }

  .json-data {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-top: 1rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    white-space: pre-wrap;
    max-height: 300px;
    overflow-y: auto;
  }

  .close-response {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #6b7280;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 50%;
    transition: all 0.2s ease;
  }

  .close-response:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #374151;
  }

  /* Loading overlay */
  .form-loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
  }

  .loading-content {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  }

  .loading-spinner {
    width: 3rem;
    height: 3rem;
    border: 3px solid #e5e7eb;
    border-top: 3px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Page Header */
  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
  }

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
  }

  .page-header .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
  }

  .page-header .btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
  }

  /* Form Container */
  .application-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
  }

  /* Section Headers */
  .section-header {
    background: #f8fafc;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .section-title {
    color: #374151;
    font-weight: 600;
    font-size: 1.125rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .section-subtitle {
    color: #6b7280;
    margin: 0.5rem 0 0 0;
    font-size: 0.875rem;
  }

  /* Form Styling */
  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-control,
  .form-select {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: white;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }

  /* Document Upload Cards - Ultra Compact */
  .document-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 0.75rem; /* Further reduced from 1rem */
    margin-bottom: 0.5rem; /* Further reduced from 0.75rem */
    transition: all 0.2s ease;
  }

  .document-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem; /* Further reduced from 1rem */
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f9fafb;
    min-height: 50px; /* Reduced from 80px */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .file-upload-area:hover {
    border-color: #3b82f6;
    background: #f3f4f6;
  }

  .upload-icon {
    color: #6b7280;
    font-size: 1.2rem; /* Further reduced from 1.5rem */
    margin-bottom: 0.125rem; /* Further reduced */
  }

  .upload-text {
    color: #374151;
    font-weight: 500;
    margin: 0;
    font-size: 0.75rem; /* Further reduced from 0.875rem */
    line-height: 1.2;
  }

  .upload-hint {
    color: #6b7280;
    font-size: 0.65rem; /* Further reduced from 0.7rem */
    margin: 0.05rem 0 0 0; /* Minimal spacing */
    line-height: 1.1;
  }

  /* Additional compact optimizations */
  .document-card h6 {
    font-size: 0.8rem; /* Further reduced */
    font-weight: 600;
    margin-bottom: 0.25rem !important;
  }
  
  .document-card .small {
    font-size: 0.65rem; /* Further reduced */
    line-height: 1.1;
    margin-bottom: 0.5rem !important;
  }
  
  /* Reduce section padding */
  .form-section .p-4 {
    padding: 1rem !important; /* Further reduced from 1.5rem */
  }
  
  /* Make document icons smaller */
  .document-card .text-center i {
    font-size: 1.2rem !important; /* Override inline styles */
  }
  
  /* Ultra compact layout for Required Documents */
  .required-docs-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.5rem;
  }
  
  /* Make the entire section more compact */
  .form-section {
    margin-bottom: 1rem;
  }
  
  .section-header {
    padding: 0.75rem 1rem;
  }
  
  .section-title {
    font-size: 1rem;
    margin-bottom: 0.25rem;
  }
  
  .section-subtitle {
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
  }

  /* Terms Agreement */
  .terms-agreement {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }

  .form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
  }

  /* Submit Button */
  .btn-submit {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: 500;
    color: white;
    width: 100%;
    transition: all 0.2s ease;
  }

  .btn-submit:hover {
    background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%);
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
    transform: translateY(-2px);
    color: white;
  }

  /* Layout Grid */
  .form-sections-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .page-header {
      padding: 1.5rem;
    }

    .page-header h4 {
      font-size: 1.25rem;
    }

    .form-sections-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .section-header {
      padding: 1rem;
    }

    .document-card {
      padding: 0.5rem; /* Ultra compact for mobile */
    }

    .file-upload-area {
      padding: 0.4rem; /* Ultra compact for mobile */
      min-height: 40px; /* Very small on mobile */
    }
    
    .upload-icon {
      font-size: 1rem; /* Very small icon on mobile */
    }
    
    .upload-text {
      font-size: 0.7rem; /* Very small text on mobile */
    }
    
    .upload-hint {
      font-size: 0.6rem; /* Very small hint on mobile */
    }

    /* Mobile responsiveness for Java response message */
    .java-response-message {
      margin: 1rem;
      padding: 1rem;
    }

    .response-header {
      flex-direction: column;
      text-align: center;
      gap: 0.5rem;
    }

    .response-icon {
      align-self: center;
    }

    .json-data {
      font-size: 0.75rem;
      max-height: 200px;
    }

    .loading-content {
      margin: 1rem;
      padding: 1.5rem;
    }
  }

  /* Icons */
  .text-primary {
    color: #3b82f6 !important;
  }

  .text-muted {
    color: #6b7280 !important;
  }

  .text-success {
    color: #10b981 !important;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-building me-2"></i>Vendor Application</h4>
        <p class="mb-0 opacity-75">Join our network of trusted suppliers and wholesalers</p>
      </div>
      <a href="{{ route('dashboard') }}" class="btn">
        <i class="bi bi-house-door me-1"></i>Dashboard
      </a>
    </div>
  </div>

  <!-- Java Server Response Message Container -->
  <div id="javaResponseMessage" class="java-response-message">
    <button type="button" class="close-response" onclick="closeResponseMessage()">
      <i class="bi bi-x-lg"></i>
    </button>
    <div class="response-header">
      <div id="responseIcon" class="response-icon">
        <i id="responseIconSymbol" class="bi bi-check-circle-fill"></i>
      </div>
      <div>
        <h6 id="responseTitle" class="response-title">Java Server Response</h6>
        <p id="responseSubtitle" class="response-subtitle">Document verification completed</p>
      </div>
    </div>
    <div class="response-content">
      <p id="responseMessage" class="response-message"></p>
      <p id="responseAdditionalInfo" class="response-additional-info"></p>
    </div>
    <div id="jsonDataContainer" class="json-data" style="display: none;"></div>
    <div class="mt-3">
      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleJsonData()">
        <i class="bi bi-code-square me-1"></i>
        <span id="toggleJsonText">Show Raw JSON</span>
      </button>
    </div>
  </div>

  <!-- Loading Overlay -->
  <div id="formLoadingOverlay" class="form-loading-overlay">
    <div class="loading-content">
      <div class="loading-spinner"></div>
      <h5>Processing Application</h5>
      <p class="text-muted">Verifying documents with Java server...</p>
    </div>
  </div>

  <!-- Application Form -->
  <div class="application-container">
    <form id="vendorApplicationForm" action="{{ route('vendor.submit') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="form-sections-grid">
        <!-- Company Information Section -->
        <div class="form-section">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-building text-primary"></i>
              Company Information
            </h5>
            <p class="section-subtitle">Tell us about your business and operations</p>
          </div>
          <div class="p-4">
            <div class="form-group">
              <label for="name" class="form-label">
                <i class="bi bi-building text-muted"></i>
                Company Name *
              </label>
              <input type="text" class="form-control" id="name" name="name" 
                     placeholder="Enter your company name" value="{{ old('name') }}" required>
            </div>
            
            <div class="form-group">
              <label for="email" class="form-label">
                <i class="bi bi-envelope text-muted"></i>
                Business Email *
              </label>
              <input type="email" class="form-control" id="email" name="email" 
                     placeholder="Enter your business email" value="{{ old('email') }}" required>
            </div>
            
            <div class="form-group">
              <label for="type" class="form-label">
                <i class="bi bi-tags text-muted"></i>
                Vendor Type *
              </label>
              <select class="form-select" id="type" name="type" required>
                <option value="">Select your vendor type</option>
                <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                <option value="wholesaler" {{ old('type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="tin" class="form-label">
                <i class="bi bi-credit-card text-muted"></i>
                Tax ID (TIN) *
              </label>
              <input type="text" class="form-control" id="tin" name="tin" 
                     placeholder="Enter your TIN number" value="{{ old('tin') }}" required>
            </div>
            
            <div class="form-group">
              <label for="address" class="form-label">
                <i class="bi bi-geo-alt text-muted"></i>
                Company Address *
              </label>
              <textarea class="form-control" id="address" name="address" rows="3" 
                        placeholder="Enter your complete company address" required>{{ old('address') }}</textarea>
            </div>
          </div>
        </div>

        <!-- Required Documents Section -->
        <div class="form-section">
          <div class="section-header" style="padding-bottom: 0.5rem;"> <!-- Reduced padding -->
            <h5 class="section-title" style="margin-bottom: 0.25rem;"> <!-- Reduced margin -->
              <i class="bi bi-file-earmark-text text-primary"></i>
              Required Documents
            </h5>
            <p class="section-subtitle" style="margin-bottom: 0.5rem; font-size: 0.8rem;">Upload all required business documents for verification</p> <!-- Smaller text, reduced margin -->
          </div>
          <div class="p-2"> <!-- Changed from p-4 to p-2 for ultra compact -->
            <div class="required-docs-container">
            <div class="document-card">
              <div class="text-center mb-1"> <!-- Further reduced from mb-2 -->
                <i class="bi bi-award" style="font-size: 1.2rem; color: #f59e0b;"></i> <!-- Further reduced icon -->
                <h6 class="mt-0 mb-0">Certificate of Registration</h6> <!-- Removed margins -->
                <p class="text-muted small mb-1">Official company registration certificate</p> <!-- Minimal margin -->
              </div>
              <div class="file-upload-area" onclick="document.getElementById('registration_cert').click()">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="upload-text">Click to upload or drag & drop</p>
                <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
              </div>
              <input type="file" class="d-none" id="registration_cert" 
                     name="registration_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            
            <div class="document-card">
              <div class="text-center mb-1"> <!-- Further reduced from mb-2 -->
                <i class="bi bi-file-earmark-check" style="font-size: 1.2rem; color: #06b6d4;"></i> <!-- Further reduced icon -->
                <h6 class="mt-0 mb-0">URSB Registration</h6> <!-- Removed margins -->
                <p class="text-muted small mb-1">Uganda Registration Services Bureau document</p> <!-- Minimal margin -->
              </div>
              <div class="file-upload-area" onclick="document.getElementById('ursb_document').click()">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="upload-text">Click to upload or drag & drop</p>
                <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
              </div>
              <input type="file" class="d-none" id="ursb_document" 
                     name="ursb_document" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            
            <div class="document-card">
              <div class="text-center mb-1"> <!-- Further reduced from mb-2 -->
                <i class="bi bi-shield-check" style="font-size: 1.2rem; color: #10b981;"></i> <!-- Further reduced icon -->
                <h6 class="mt-0 mb-0">Trading License</h6> <!-- Removed margins -->
                <p class="text-muted small mb-1">Valid business trading license</p> <!-- Minimal margin -->
              </div>
              <div class="file-upload-area" onclick="document.getElementById('trading_license').click()">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="upload-text">Click to upload or drag & drop</p>
                <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
              </div>
              <input type="file" class="d-none" id="trading_license" 
                     name="trading_license" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            </div> <!-- Close required-docs-container -->
          </div>
        </div>

        <!-- Final Confirmation Section -->
        <div class="form-section">
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-check-circle text-primary"></i>
              Final Confirmation
            </h5>
            <p class="section-subtitle">Review and confirm your application details</p>
          </div>
          <div class="p-4">
            <div class="terms-agreement">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terms" required>
                <label class="form-check-label ms-2" for="terms">
                  <strong>I hereby confirm that:</strong>
                  <ul class="mt-2 mb-0" style="list-style: none; padding-left: 0;">
                    <li><i class="bi bi-check text-success me-2"></i>All information provided is accurate and truthful</li>
                    <li><i class="bi bi-check text-success me-2"></i>I have uploaded all required documents</li>
                    <li><i class="bi bi-check text-success me-2"></i>I agree to the <a href="#" class="text-primary fw-semibold">Terms of Service</a> and <a href="#" class="text-primary fw-semibold">Privacy Policy</a></li>
                    <li><i class="bi bi-check text-success me-2"></i>I understand that verification may take 3-5 business days</li>
                  </ul>
                </label>
              </div>
            </div>
            
            <div class="text-center">
              <button type="submit" class="btn btn-submit">
                <i class="bi bi-send me-2"></i>
                Submit Application
              </button>
              <p class="text-muted mt-3 small">
                <i class="bi bi-shield-alt me-1"></i>
                Your application will be reviewed within 3-5 business days
              </p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload functionality
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const uploadArea = this.previousElementSibling;
            const fileName = this.files[0] ? this.files[0].name : null;
            
            if (fileName) {
                uploadArea.innerHTML = `
                    <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p class="upload-text" style="color: #10b981; font-weight: 500;">${fileName}</p>
                    <p class="upload-hint">File uploaded successfully</p>
                `;
                uploadArea.style.borderColor = '#10b981';
                uploadArea.style.backgroundColor = '#f0fdf4';
            }
        });
    });

    // AJAX Form Submission Handler
    const vendorForm = document.getElementById('vendorApplicationForm');
    if (vendorForm) {
        vendorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitVendorApplication();
        });
    }
});

// Submit vendor application via AJAX
async function submitVendorApplication() {
    const form = document.getElementById('vendorApplicationForm');
    const formData = new FormData(form);
    
    // Show loading overlay
    showLoadingOverlay();
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value || ''
            }
        });

        const responseData = await response.json();
        
        // Hide loading overlay
        hideLoadingOverlay();
        
        // Display Java server response
        displayJavaServerResponse(responseData, response.status);
        
    } catch (error) {
        console.error('Application submission error:', error);
        hideLoadingOverlay();
        
        // Display error response
        displayJavaServerResponse({
            status: 'error',
            message: 'Failed to submit application. Please try again.',
            additional_info: error.message
        }, 500);
    }
}

// Display Java server response at the top of the page
function displayJavaServerResponse(data, statusCode) {
    const messageContainer = document.getElementById('javaResponseMessage');
    const responseIcon = document.getElementById('responseIcon');
    const responseIconSymbol = document.getElementById('responseIconSymbol');
    const responseTitle = document.getElementById('responseTitle');
    const responseSubtitle = document.getElementById('responseSubtitle');
    const responseMessage = document.getElementById('responseMessage');
    const responseAdditionalInfo = document.getElementById('responseAdditionalInfo');
    const jsonDataContainer = document.getElementById('jsonDataContainer');
    
    // Determine response type and styling
    let responseType = 'pending';
    let iconClass = 'bi bi-clock-fill';
    let title = 'Application Processing';
    let subtitle = 'Java server response received';
    
    if (data.status === 'success' || statusCode === 200) {
        responseType = 'success';
        iconClass = 'bi bi-check-circle-fill';
        title = 'Application Approved!';
        subtitle = 'Document verification successful';
    } else if (data.status === 'error' || statusCode >= 400) {
        responseType = 'error';
        iconClass = 'bi bi-x-circle-fill';
        title = 'Application Failed';
        subtitle = 'Document verification failed';
    } else if (data.status === 'pending') {
        responseType = 'pending';
        iconClass = 'bi bi-clock-fill';
        title = 'Application Pending';
        subtitle = 'Manual review required';
    }
    
    // Apply styling classes
    messageContainer.className = `java-response-message ${responseType}`;
    responseIcon.className = `response-icon ${responseType}`;
    responseIconSymbol.className = iconClass;
    
    // Set content
    responseTitle.textContent = title;
    responseSubtitle.textContent = subtitle;
    responseMessage.textContent = data.message || 'No message provided';
    responseAdditionalInfo.textContent = data.additional_info || '';
    
    // Set JSON data for raw display
    jsonDataContainer.textContent = JSON.stringify(data, null, 2);
    
    // Show the message container
    messageContainer.style.display = 'block';
    
    // Scroll to top to show the response
    messageContainer.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start' 
    });
    
    // Add animation effect
    messageContainer.style.opacity = '0';
    messageContainer.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        messageContainer.style.transition = 'all 0.5s ease';
        messageContainer.style.opacity = '1';
        messageContainer.style.transform = 'translateY(0)';
    }, 100);
}

// Show loading overlay
function showLoadingOverlay() {
    const overlay = document.getElementById('formLoadingOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

// Hide loading overlay
function hideLoadingOverlay() {
    const overlay = document.getElementById('formLoadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Close response message
function closeResponseMessage() {
    const messageContainer = document.getElementById('javaResponseMessage');
    if (messageContainer) {
        messageContainer.style.display = 'none';
    }
}

// Toggle JSON data visibility
function toggleJsonData() {
    const jsonContainer = document.getElementById('jsonDataContainer');
    const toggleText = document.getElementById('toggleJsonText');
    
    if (jsonContainer.style.display === 'none') {
        jsonContainer.style.display = 'block';
        toggleText.textContent = 'Hide Raw JSON';
    } else {
        jsonContainer.style.display = 'none';
        toggleText.textContent = 'Show Raw JSON';
    }
}
</script>
@endsection
