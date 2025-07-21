<x-layout bodyClass="">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        .auth-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%2310b981" opacity="0.3"/><circle cx="80" cy="40" r="1.5" fill="%236366f1" opacity="0.4"/><circle cx="40" cy="80" r="1" fill="%23f59e0b" opacity="0.3"/><circle cx="70" cy="70" r="1.2" fill="%2310b981" opacity="0.5"/></svg>');
            animation: float-particles 20s infinite linear;
        }
        
        @keyframes float-particles {
            0% { transform: translateY(100vh) rotate(0deg); }
            100% { transform: translateY(-100vh) rotate(360deg); }
        }
        
        .auth-container {
            max-width: 500px;
            width: 100%;
            margin: 2rem;
            z-index: 2;
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .auth-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            animation: pulse-logo 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulse-logo {
            0% { transform: scale(1); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3); }
            100% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4); }
        }
        
        .auth-logo i {
            font-size: 2rem;
            color: white;
        }
        
        .auth-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            color: #64748b;
            font-size: 1rem;
            font-weight: 400;
        }
        
        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .social-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }
        
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .social-btn.facebook { color: #1877f2; }
        .social-btn.github { color: #333; }
        .social-btn.google { color: #ea4335; }
        
        .social-btn.facebook:hover { 
            background: #1877f2; 
            color: white; 
            border-color: #1877f2;
        }
        .social-btn.github:hover { 
            background: #333; 
            color: white; 
            border-color: #333;
        }
        .social-btn.google:hover { 
            background: #ea4335; 
            color: white; 
            border-color: #ea4335;
        }
        
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
            z-index: 1;
        }
        
        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 1rem;
            position: relative;
            z-index: 2;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #d1d5db;
            background: white;
            margin-top: 2px;
            flex-shrink: 0;
        }
        
        .form-check-input:checked {
            background: #10b981;
            border-color: #10b981;
        }
        
        .form-check-label {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.4;
        }
        
        .form-check-label a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-check-label a:hover {
            color: #059669;
            text-decoration: underline;
        }
        
        .btn-primary-modern {
            width: 100%;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            margin: 1.5rem 0;
            cursor: pointer;
        }
        
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .auth-footer a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .auth-footer a:hover {
            color: #059669;
            text-decoration: underline;
        }
        
        /* Floating Elements */
        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .floating-icon {
            position: absolute;
            font-size: 1.5rem;
            color: rgba(16, 185, 129, 0.4);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }
        
        .floating-icon:nth-child(1) {
            top: 15%;
            left: 8%;
            animation: float-1 6s ease-in-out infinite;
        }
        
        .floating-icon:nth-child(2) {
            top: 70%;
            right: 10%;
            animation: float-2 8s ease-in-out infinite;
        }
        
        .floating-icon:nth-child(3) {
            bottom: 25%;
            left: 15%;
            animation: float-3 7s ease-in-out infinite;
        }
        
        @keyframes float-1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(180deg); }
        }
        
        @keyframes float-2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(-180deg); }
        }
        
        @keyframes float-3 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(180deg); }
        }
        
        /* Back to Home Button */
        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }
        
        .back-home a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-home a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
        }
        
        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #dc2626;
            border: 1px solid #f87171;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .auth-title {
                font-size: 2rem;
            }
            
            .social-login {
                flex-direction: column;
            }
            
            .back-home {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>

    <div class="auth-section">
        <div class="floating-particles"></div>
        
        <!-- Back to Home Button -->
        <div class="back-home">
            <a href="{{ url('/') }}">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Home</span>
            </a>
        </div>
        
        <!-- Floating Icons -->
        <div class="floating-icons">
            <div class="floating-icon">
                <i class="bi bi-person-plus"></i>
            </div>
            <div class="floating-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="floating-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
        
        <div class="auth-container">
            <div class="auth-card">
                <!-- Header -->
                <div class="auth-header">
                    <div class="auth-logo">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h1 class="auth-title">Join Ecoverse</h1>
                    <p class="auth-subtitle">Create your account and start making a difference</p>
                </div>
                
                <!-- Social Login -->
                <div class="social-login">
                    <a href="#" class="social-btn facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-btn github">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="#" class="social-btn google">
                        <i class="bi bi-google"></i>
                    </a>
                </div>
                
                <div class="divider">
                    <span>or create account with email</span>
                </div>
                
                <!-- Sign Up Form -->
                <form role="form" method="POST" action="{{ url('/sign-up') }}">
                    @csrf
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" required 
                               placeholder="Enter your full name" value="{{ old('name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" required 
                               placeholder="Enter your email address" value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required 
                               placeholder="Create a strong password">
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="termsConditions" required>
                        <label class="form-check-label" for="termsConditions">
                            I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>. I understand that Ecoverse will use my information to provide waste management services and communicate about sustainable practices.
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-primary-modern">
                        Create Ecoverse Account
                    </button>
                </form>
                
                <!-- Footer -->
                <div class="auth-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</x-layout>
