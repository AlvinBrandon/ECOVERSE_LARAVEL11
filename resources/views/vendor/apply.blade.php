@extends('layouts.app')

@section('title', 'Vendor Application - Join Our Network')

@push('styles')
<style>
.vendor-application-container {
    background: #f8fafc;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 2rem 0;
}
.application-wrapper {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    border: 1px solid #e3f2fd;
    overflow: hidden;
    max-width: 1200px;
    width: 95vw;
    margin: 2rem auto;
}
.form-container.landscape-layout {
    flex-direction: row !important;
    align-items: stretch !important;
    gap: 2rem !important;
    width: 100%;
    justify-content: space-between;
    padding: 2rem 2rem;
}
.form-section-card {
    min-width: 320px;
    max-width: 100%;
    flex: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
@media (max-width: 1200px) {
    .application-wrapper {
        max-width: 100vw;
        width: 100vw;
        border-radius: 0;
    }
    .form-container.landscape-layout {
        flex-direction: column !important;
        gap: 1rem !important;
        padding: 1rem 0.5rem;
    }
    .form-section-card {
        max-width: 100vw;
        min-width: 0;
    }
}
</style>
@endpush

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="#">Vendor Application</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i>Customer Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="vendor-application-container">
    <div class="application-wrapper">
        <h2 class="text-center fw-bold mb-4" style="color:#1976d2;">Vendor Application</h2>
        <div class="form-container landscape-layout">
            <form action="{{ route('vendor.apply') }}" method="POST" enctype="multipart/form-data" class="vendor-form" style="width:100%">
                @csrf
                <div style="display: flex; flex-direction: row; gap: 2rem; justify-content: center; align-items: flex-start; width: 100%;">
                    <div class="form-section-card" style="flex:1; min-width: 300px;">
                        <div class="section-header">
                            <h4 class="section-title">
                                <i class="fas fa-building text-primary me-2"></i>
                                Company Information
                            </h4>
                            <p class="section-subtitle">Tell us about your business and operations</p>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-building text-muted me-2"></i>Company Name *
                            </label>
                            <input type="text" class="form-control form-control-modern" id="name" name="name" 
                                   placeholder="Enter your company name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope text-muted me-2"></i>Business Email *
                            </label>
                            <input type="email" class="form-control form-control-modern" id="email" name="email" 
                                   placeholder="Enter your business email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-label">
                                <i class="fas fa-tags text-muted me-2"></i>Vendor Type *
                            </label>
                            <select class="form-select form-select-modern" id="type" name="type" required>
                                <option value="">Select your vendor type</option>
                                <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                <option value="wholesaler" {{ old('type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tin" class="form-label">
                                <i class="fas fa-id-card text-muted me-2"></i>Tax ID (TIN) *
                            </label>
                            <input type="text" class="form-control form-control-modern" id="tin" name="tin" 
                                   placeholder="Enter your TIN number" value="{{ old('tin') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt text-muted me-2"></i>Company Address *
                            </label>
                            <textarea class="form-control form-control-modern" id="address" name="address" rows="3" 
                                      placeholder="Enter your complete company address" required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="form-section-card" style="flex:1; min-width: 300px;">
                        <div class="section-header">
                            <h4 class="section-title">
                                <i class="fas fa-file-upload text-primary me-2"></i>
                                Required Documents
                            </h4>
                            <p class="section-subtitle">Upload all required business documents for verification</p>
                        </div>
                        <div class="documents-grid" style="flex-direction: column; gap: 1rem;">
                            <div class="document-card">
                                <div class="text-center mb-3">
                                    <i class="fas fa-certificate" style="font-size: 2rem; color: #f59e0b;"></i>
                                    <h6 class="mt-2 mb-1">Certificate of Registration</h6>
                                    <p class="text-muted small mb-3">Official company registration certificate</p>
                                </div>
                                <div class="file-upload-area" onclick="document.getElementById('registration_cert').click()">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Click to upload or drag & drop</p>
                                    <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" class="d-none" id="registration_cert" 
                                       name="registration_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="document-card">
                                <div class="text-center mb-3">
                                    <i class="fas fa-file-contract" style="font-size: 2rem; color: #06b6d4;"></i>
                                    <h6 class="mt-2 mb-1">URSB Registration</h6>
                                    <p class="text-muted small mb-3">Uganda Registration Services Bureau document</p>
                                </div>
                                <div class="file-upload-area" onclick="document.getElementById('ursb_document').click()">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Click to upload or drag & drop</p>
                                    <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" class="d-none" id="ursb_document" 
                                       name="ursb_document" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="document-card">
                                <div class="text-center mb-3">
                                    <i class="fas fa-balance-scale" style="font-size: 2rem; color: #10b981;"></i>
                                    <h6 class="mt-2 mb-1">Trading License</h6>
                                    <p class="text-muted small mb-3">Valid business trading license</p>
                                </div>
                                <div class="file-upload-area" onclick="document.getElementById('trading_license').click()">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Click to upload or drag & drop</p>
                                    <p class="upload-hint">PDF, JPG, PNG (Max: 5MB)</p>
                                </div>
                                <input type="file" class="d-none" id="trading_license" 
                                       name="trading_license" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-section-card" style="flex:1; min-width: 300px;">
                        <div class="section-header">
                            <h4 class="section-title">
                                <i class="fas fa-file-signature text-primary me-2"></i>
                                Final Confirmation
                            </h4>
                            <p class="section-subtitle">Review and confirm your application details</p>
                        </div>
                        <div class="terms-agreement p-4" style="background: #f8fafc; border-radius: 10px; border-left: 4px solid #10b981;">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required style="transform: scale(1.2);">
                                <label class="form-check-label ms-2" for="terms" style="font-size: 1rem;">
                                    <strong>I hereby confirm that:</strong>
                                    <ul class="mt-2 mb-0" style="list-style: none; padding-left: 0;">
                                        <li><i class="fas fa-check text-success me-2"></i>All information provided is accurate and truthful</li>
                                        <li><i class="fas fa-check text-success me-2"></i>I have uploaded all required documents</li>
                                        <li><i class="fas fa-check text-success me-2"></i>I agree to the <a href="#" class="text-primary fw-semibold">Terms of Service</a> and <a href="#" class="text-primary fw-semibold">Privacy Policy</a></li>
                                        <li><i class="fas fa-check text-success me-2"></i>I understand that verification may take 3-5 business days</li>
                                    </ul>
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Application
                            </button>
                            <p class="text-muted mt-3 small">
                                <i class="fas fa-shield-alt me-1"></i>
                                Your application will be reviewed within 3-5 business days
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modern Vendor Application Styles */
.vendor-application-page {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.hero-section {
    padding: 100px 0 50px 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
}

.min-vh-50 {
    min-height: 50vh;
}

.feature-item {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.form-section {
    background: #f8f9fa;
    padding: 50px 0;
    margin-top: -50px;
    border-radius: 50px 50px 0 0;
}

.application-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 3rem;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 2rem 2rem 2rem;
    border: none;
}

.header-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    font-size: 2rem;
}

.progress-steps {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

.step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0.6;
    transition: all 0.3s ease;
}

.step.active {
    opacity: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.step.active .step-number {
    background: white;
    color: #667eea;
}

.card-body {
    padding: 3rem;
}

.form-section-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #e9ecef;
}

.section-header {
    margin-bottom: 2rem;
    text-align: center;
}

.section-title {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #718096;
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.document-upload-card {
    background: white;
    border: 2px dashed #e2e8f0;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
}

.document-upload-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.document-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.document-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.document-desc {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.document-input {
    margin-bottom: 0.5rem;
}

.upload-info {
    color: #a0aec0;
    font-size: 0.8rem;
}

.terms-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.custom-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.custom-checkbox .form-check-input {
    margin-top: 0.25rem;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 1rem 3rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    width: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-submit:hover .btn-shine {
    left: 100%;
}

.alert-modern {
    border: none;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-icon {
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.alert-title {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        padding: 60px 0 30px 0;
    }
    
    .card-header {
        padding: 2rem 1rem 1.5rem 1rem;
    }
    
    .card-body {
        padding: 2rem 1rem;
    }
    
    .progress-steps {
        gap: 1rem;
        font-size: 0.9rem;
    }
    
    .documents-grid {
        grid-template-columns: 1fr;
    }
    
    .form-section-card {
        padding: 1.5rem;
    }
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload functionality
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const uploadArea = this.previousElementSibling;
            const fileName = this.files[0]?.name;
            
            if (fileName) {
                uploadArea.innerHTML = `
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem;"></i>
                    <p class="upload-text" style="color: #10b981; font-weight: 600;">File Selected</p>
                    <p class="upload-hint">${fileName}</p>
                `;
                uploadArea.style.borderColor = '#10b981';
                uploadArea.style.background = '#ecfdf5';
            }
        });
    });
    
    // Drag and drop functionality
    const uploadAreas = document.querySelectorAll('.file-upload-area');
    
    uploadAreas.forEach(area => {
        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        area.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });
        
        area.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const fileInput = this.nextElementSibling;
            const files = e.dataTransfer.files;
            
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // Form validation enhancement
    const form = document.querySelector('.vendor-form');
    const submitBtn = document.querySelector('.btn-submit');
    
    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = `
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Processing Application...
        `;
        submitBtn.disabled = true;
    });
    
    // Step progress animation
    const progressSteps = document.querySelectorAll('.step');
    let currentStep = 0;
    
    function updateStepProgress() {
        progressSteps.forEach((step, index) => {
            if (index <= currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }
    
    // Form field completion tracking
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('change', function() {
            const completedFields = Array.from(requiredFields).filter(f => f.value.trim() !== '').length;
            const progress = Math.floor((completedFields / requiredFields.length) * 2);
            
            if (progress !== currentStep && progress <= 2) {
                currentStep = progress;
                updateStepProgress();
            }
        });
    });
    
    // Smooth scrolling for form navigation
    const sections = document.querySelectorAll('.form-section-card');
    
    sections.forEach((section, index) => {
        section.addEventListener('click', function() {
            if (index > 0) {
                this.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    // Enhanced tooltips for icons
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
});
</script>
@endpush
