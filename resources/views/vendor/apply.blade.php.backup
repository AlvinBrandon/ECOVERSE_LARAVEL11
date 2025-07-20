@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #e91e63;
            --primary-dark: #c2185b;
            --secondary: #3949ab;
            --light-bg: #f9fafb;
            --dark-text: #2d3748;
            --gray: #718096;
            --light-gray: #e2e8f0;
            --success: #38a169;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #f8f9fa 100%);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .vendor-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            min-height: 600px;
        }
        
        .vendor-illustration {
            flex: 1;
            background: linear-gradient(135deg, #f0f2f5 0%, #e91e63 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .illustration-content {
            text-align: center;
            z-index: 2;
        }
        
        .vendor-illustration img {
            max-width: 320px;
            width: 100%;
            margin-bottom: 30px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
        }
        
        .vendor-illustration h2 {
            color: white;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .vendor-illustration p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 16px;
            max-width: 350px;
            line-height: 1.6;
        }
        
        .illustration-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background: radial-gradient(circle at top right, var(--primary) 0%, transparent 50%);
        }
        
        .vendor-form {
            flex: 1;
            padding: 40px;
            background: white;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .form-header h2 {
            color: var(--primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            display: inline-block;
        }
        
        .form-header h2:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .form-header p {
            color: var(--gray);
            font-size: 16px;
            margin-top: 20px;
            line-height: 1.6;
        }
        
        .form-step {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--gray);
            margin-right: 10px;
        }
        
        .step.active {
            background: var(--primary);
            color: white;
        }
        
        .step-text {
            font-weight: 500;
            color: var(--dark-text);
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-text);
            font-size: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--light-gray);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.15);
        }
        
        .select-wrapper {
            position: relative;
        }
        
        .select-wrapper:after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            pointer-events: none;
        }
        
        select.form-control {
            appearance: none;
            cursor: pointer;
        }
        
        .file-upload {
            position: relative;
            display: flex;
            align-items: center;
            padding: 12px;
            border: 2px dashed var(--light-gray);
            border-radius: 8px;
            background: var(--light-bg);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .file-upload:hover {
            border-color: var(--primary);
        }
        
        .file-upload input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-upload span {
            margin-left: 12px;
            color: var(--gray);
            font-size: 14px;
        }
        
        .file-upload i {
            color: var(--primary);
            font-size: 20px;
        }
        
        .file-info {
            margin-top: 8px;
            color: var(--gray);
            font-size: 13px;
            display: block;
        }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(233, 30, 99, 0.3);
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(233, 30, 99, 0.4);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: var(--gray);
            font-size: 14px;
        }
        
        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 15px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background: rgba(56, 161, 105, 0.15);
            color: var(--success);
            border: 1px solid rgba(56, 161, 105, 0.25);
        }
        
        .alert i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        @media (max-width: 768px) {
            .vendor-container {
                flex-direction: column;
            }
            
            .vendor-illustration {
                padding: 30px 20px;
            }
            
            .vendor-illustration img {
                max-width: 220px;
            }
            
            .vendor-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="vendor-container">
        <div class="vendor-illustration">
            <div class="illustration-bg"></div>
            <div class="illustration-content">
                <img src="https://cdn-icons-png.flaticon.com/512/3759/3759263.png" alt="Vendor Application">
                <h2>Join Our Vendor Network</h2>
                <p>Expand your business reach by becoming a trusted supplier or wholesaler on our platform</p>
            </div>
        </div>
        
        <div class="vendor-form">
            <div class="form-header">
                <h2>Become a Vendor</h2>
                <p>Fill in your company details to apply as a supplier or wholesaler. All fields are required.</p>
            </div>
            
            <div class="form-step">
                <div class="step active">1</div>
                <div class="step-text">Company Information</div>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif
            
            <form action="{{ route('vendor.apply') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name"><i class="fas fa-building"></i> Company Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your company name" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Business Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your business email" value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="type"><i class="fas fa-tags"></i> Vendor Type</label>
                    <div class="select-wrapper">
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select your vendor type</option>
                            <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                            <option value="wholesaler" {{ old('type') == 'wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="document"><i class="fas fa-file-contract"></i> URSB Registration</label>
                    <div class="file-upload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload URSB document</span>
                        <input type="file" id="document" name="ursb_document" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <small class="file-info">Accepted formats: PDF, JPG, PNG (Max size: 5MB)</small>
                </div>
                
                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Company Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your company physical address" value="{{ old('address') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="tin"><i class="fas fa-id-card"></i> Tax Identification Number (TIN)</label>
                    <input type="text" class="form-control" id="tin" name="tin" placeholder="Enter your TIN" value="{{ old('tin') }}" required>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Submit Application
                </button>
            </form>
            
            <div class="form-footer">
                <p>By submitting this application, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('.file-upload input');
            const fileUpload = document.querySelector('.file-upload');
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileUpload.querySelector('span').textContent = fileName;
                }
            });
            
            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let valid = true;
                
                document.querySelectorAll('input, select').forEach(input => {
                    if (!input.value) {
                        input.style.borderColor = '#e53e3e';
                        valid = false;
                    } else {
                        input.style.borderColor = '';
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                } else {
                    // Simulate form submission
                    e.preventDefault();
                    alert('Application submitted successfully!');
                }
            });
        });
    </script>
</body>
</html>
@endsection 