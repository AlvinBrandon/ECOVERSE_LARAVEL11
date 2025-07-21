@extends('layouts.app')

@section('content')
<style>
  /* Modern Professional Vendor Application Styling */
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
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

  /* Document Upload Cards */
  .document-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
  }

  .document-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  }

  .file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f9fafb;
  }

  .file-upload-area:hover {
    border-color: #3b82f6;
    background: #f3f4f6;
  }

  .upload-icon {
    color: #6b7280;
    font-size: 2rem;
    margin-bottom: 0.5rem;
  }

  .upload-text {
    color: #374151;
    font-weight: 500;
    margin: 0;
  }

  .upload-hint {
    color: #6b7280;
    font-size: 0.75rem;
    margin: 0.25rem 0 0 0;
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
      padding: 1rem;
    }

    .file-upload-area {
      padding: 1rem;
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

  <!-- Application Form -->
  <div class="application-container">
    <form action="{{ route('vendor.apply') }}" method="POST" enctype="multipart/form-data">
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
          <div class="section-header">
            <h5 class="section-title">
              <i class="bi bi-file-earmark-text text-primary"></i>
              Required Documents
            </h5>
            <p class="section-subtitle">Upload all required business documents for verification</p>
          </div>
          <div class="p-4">
            <div class="document-card">
              <div class="text-center mb-3">
                <i class="bi bi-award" style="font-size: 2rem; color: #f59e0b;"></i>
                <h6 class="mt-2 mb-1">Certificate of Registration</h6>
                <p class="text-muted small mb-3">Official company registration certificate</p>
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
              <div class="text-center mb-3">
                <i class="bi bi-file-earmark-check" style="font-size: 2rem; color: #06b6d4;"></i>
                <h6 class="mt-2 mb-1">URSB Registration</h6>
                <p class="text-muted small mb-3">Uganda Registration Services Bureau document</p>
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
              <div class="text-center mb-3">
                <i class="bi bi-shield-check" style="font-size: 2rem; color: #10b981;"></i>
                <h6 class="mt-2 mb-1">Trading License</h6>
                <p class="text-muted small mb-3">Valid business trading license</p>
              </div>
              <div class="file-upload-area" onclick="document.getElementById('trading_license').click()">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="upload-text">Click to upload or drag & drop</p>
                <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
              </div>
              <input type="file" class="d-none" id="trading_license" 
                     name="trading_license" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
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
});
</script>
@endsection
