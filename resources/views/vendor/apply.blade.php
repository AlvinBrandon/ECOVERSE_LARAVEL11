@extends('layouts.app')

@section('content')
<div class="vendor-application-page">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="badge bg-primary mb-3">
                            <i class="fas fa-store me-2"></i>Partner with Us
                        </div>
                        <h1 class="display-4 fw-bold text-white mb-4">Join Our Vendor Network</h1>
                        <p class="lead text-white-50 mb-4">Expand your business reach by becoming a verified supplier or wholesaler on our eco-friendly platform.</p>
                        <div class="row text-white">
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Verified Partner Status</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-chart-line text-success me-2"></i>
                                    <span>Growth Opportunities</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-handshake text-success me-2"></i>
                                    <span>Trusted Network</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-globe text-success me-2"></i>
                                    <span>Wider Market Reach</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Form Section -->
    <div class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="application-card">
                        <div class="card-header">
                            <div class="text-center">
                                <div class="header-icon">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <h2 class="mb-2">Vendor Application</h2>
                                <p class="text-muted mb-0">Complete all sections below to submit your application</p>
                            </div>
                            
                            <!-- Progress Steps -->
                            <div class="progress-steps mt-4">
                                <div class="step active">
                                    <div class="step-number">1</div>
                                    <div class="step-label">Company Info</div>
                                </div>
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <div class="step-label">Documents</div>
                                </div>
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <div class="step-label">Review</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-modern">
                                <div class="alert-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="alert-content">
                                    <h6 class="alert-title">Application Submitted Successfully!</h6>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($errors->any())
                            <div class="alert alert-danger alert-modern">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-content">
                                    <h6 class="alert-title">Please Fix the Following Errors:</h6>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            
                            <form action="{{ route('vendor.apply') }}" method="POST" enctype="multipart/form-data" class="vendor-form">
                                @csrf
                                
                                <!-- Company Information Section -->
                                <div class="form-section-card">
                                    <div class="section-header">
                                        <h4 class="section-title">
                                            <i class="fas fa-building text-primary me-2"></i>
                                            Company Information
                                        </h4>
                                        <p class="section-subtitle">Tell us about your business</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">
                                                    <i class="fas fa-building text-muted me-2"></i>Company Name *
                                                </label>
                                                <input type="text" class="form-control form-control-modern" id="name" name="name" 
                                                       placeholder="Enter your company name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope text-muted me-2"></i>Business Email *
                                                </label>
                                                <input type="email" class="form-control form-control-modern" id="email" name="email" 
                                                       placeholder="Enter your business email" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type" class="form-label">
                                                    <i class="fas fa-tags text-muted me-2"></i>Vendor Type *
                                                </label>
                                                <select class="form-select form-control-modern" id="type" name="type" required>
                                                    <option value="">Select your vendor type</option>
                                                    <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                                    <option value="wholesaler" {{ old('type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tin" class="form-label">
                                                    <i class="fas fa-id-card text-muted me-2"></i>Tax ID (TIN) *
                                                </label>
                                                <input type="text" class="form-control form-control-modern" id="tin" name="tin" 
                                                       placeholder="Enter your TIN number" value="{{ old('tin') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address" class="form-label">
                                            <i class="fas fa-map-marker-alt text-muted me-2"></i>Company Address *
                                        </label>
                                        <textarea class="form-control form-control-modern" id="address" name="address" rows="3" 
                                                  placeholder="Enter your complete company address" required>{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                
                                <!-- Document Upload Section -->
                                <div class="form-section-card">
                                    <div class="section-header">
                                        <h4 class="section-title">
                                            <i class="fas fa-file-upload text-primary me-2"></i>
                                            Required Documents
                                        </h4>
                                        <p class="section-subtitle">Upload all required business documents for verification</p>
                                    </div>
                                    
                                    <div class="documents-grid">
                                        <!-- Certificate of Registration -->
                                        <div class="document-upload-card">
                                            <div class="document-icon">
                                                <i class="fas fa-certificate text-warning"></i>
                                            </div>
                                            <div class="document-content">
                                                <h6 class="document-title">Certificate of Registration</h6>
                                                <p class="document-desc">Official company registration certificate</p>
                                                <input type="file" class="form-control document-input" id="registration_cert" 
                                                       name="registration_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <small class="upload-info">PDF, JPG, PNG (Max: 5MB)</small>
                                            </div>
                                        </div>
                                        
                                        <!-- URSB Document -->
                                        <div class="document-upload-card">
                                            <div class="document-icon">
                                                <i class="fas fa-file-contract text-info"></i>
                                            </div>
                                            <div class="document-content">
                                                <h6 class="document-title">URSB Registration</h6>
                                                <p class="document-desc">Uganda Registration Services Bureau document</p>
                                                <input type="file" class="form-control document-input" id="ursb_document" 
                                                       name="ursb_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <small class="upload-info">PDF, JPG, PNG (Max: 5MB)</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Trading License -->
                                        <div class="document-upload-card">
                                            <div class="document-icon">
                                                <i class="fas fa-balance-scale text-success"></i>
                                            </div>
                                            <div class="document-content">
                                                <h6 class="document-title">Trading License</h6>
                                                <p class="document-desc">Valid business trading license</p>
                                                <input type="file" class="form-control document-input" id="trading_license" 
                                                       name="trading_license" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <small class="upload-info">PDF, JPG, PNG (Max: 5MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Terms and Submit -->
                                <div class="form-section-card">
                                    <div class="terms-section">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" class="form-check-input" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I hereby confirm that all information provided is accurate and I agree to the 
                                                <a href="#" class="text-primary fw-semibold">Terms of Service</a> and 
                                                <a href="#" class="text-primary fw-semibold">Privacy Policy</a>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Submit Application
                                        <div class="btn-shine"></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
