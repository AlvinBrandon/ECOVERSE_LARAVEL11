@extends('layouts.app')

@section('content')
<style>
  body, .main-content, .container-fluid {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  .page-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    color: white;
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .page-header h4 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
    position: relative;
    z-index: 2;
  }

  .support-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .support-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
  }

  .support-card .card-body {
    padding: 1.5rem;
  }

  .faq-item {
    border-bottom: 1px solid #f3f4f6;
    padding: 1rem 0;
  }

  .faq-item:last-child {
    border-bottom: none;
  }

  .faq-question {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    cursor: pointer;
  }

  .faq-answer {
    color: #6b7280;
    font-size: 0.875rem;
    display: none;
  }

  .contact-method {
    display: block;
    text-align: center;
    padding: 2rem;
    border: 2px solid #e5e7eb;
    border-radius: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    color: inherit;
  }

  .contact-method:hover {
    border-color: #3b82f6;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
    color: inherit;
    text-decoration: none;
  }

  .contact-icon {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 1rem;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-question-circle me-2"></i>Help & Support</h4>
        <p class="mb-0 opacity-75">Get assistance and find answers to your questions</p>
      </div>
      <a href="{{ route('profile') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-1"></i>Back to Profile
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Contact Methods -->
    <div class="col-12 mb-4">
      <div class="card support-card">
        <div class="card-header">
          <h6><i class="bi bi-headset me-2"></i>Contact Support</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <a href="mailto:admin@ecoverse.com" class="contact-method text-decoration-none">
                <div class="contact-icon">
                  <i class="bi bi-envelope"></i>
                </div>
                <h6>Email Support</h6>
                <p class="text-muted mb-2">admin@ecoverse.com</p>
                <small class="text-muted">Response within 24 hours</small>
              </a>
            </div>
            <div class="col-md-4 mb-3">
              <a href="tel:+256123456789" class="contact-method text-decoration-none">
                <div class="contact-icon">
                  <i class="bi bi-telephone"></i>
                </div>
                <h6>Phone Support</h6>
                <p class="text-muted mb-2">+256 123 456 789</p>
                <small class="text-muted">Mon-Fri, 9AM-6PM</small>
              </a>
            </div>
            <div class="col-md-4 mb-3">
              <a href="{{ route('chat.index') }}" class="contact-method text-decoration-none">
                <div class="contact-icon">
                  <i class="bi bi-chat-dots"></i>
                </div>
                <h6>Live Chat</h6>
                <p class="text-muted mb-2">Available now</p>
                <small class="text-muted">Real-time assistance</small>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="col-md-8 mb-4">
      <div class="card support-card">
        <div class="card-header">
          <h6><i class="bi bi-question-circle me-2"></i>Frequently Asked Questions</h6>
        </div>
        <div class="card-body">
          <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
              <i class="bi bi-plus-circle me-2"></i>How do I place an order?
            </div>
            <div class="faq-answer">
              Browse our sustainable products, add items to your cart, and proceed to checkout. You can track your order status in your dashboard.
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
              <i class="bi bi-plus-circle me-2"></i>What are Eco Points?
            </div>
            <div class="faq-answer">
              Eco Points are rewards you earn for making sustainable purchases and choices. They can be redeemed for discounts on future orders.
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
              <i class="bi bi-plus-circle me-2"></i>How is my carbon footprint calculated?
            </div>
            <div class="faq-answer">
              We calculate your carbon footprint based on your purchasing patterns, shipping methods, and product choices. Our algorithm considers the environmental impact of each product.
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
              <i class="bi bi-plus-circle me-2"></i>Can I become a vendor?
            </div>
            <div class="faq-answer">
              Yes! We welcome eco-conscious vendors. Visit our vendor application page to learn about our partnership requirements and sustainability standards.
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
              <i class="bi bi-plus-circle me-2"></i>How do I update my profile information?
            </div>
            <div class="faq-answer">
              Go to your profile page and click the edit icon next to your profile information. You can update your personal details, preferences, and eco-settings.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="col-md-4 mb-4">
      <div class="card support-card">
        <div class="card-header">
          <h6><i class="bi bi-link-45deg me-2"></i>Quick Links</h6>
        </div>
        <div class="card-body">
          <ul class="list-unstyled">
            <li class="mb-3">
              <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <i class="bi bi-house-door me-2 text-primary"></i>Dashboard
              </a>
            </li>
            <li class="mb-3">
              <a href="{{ route('profile') }}" class="text-decoration-none">
                <i class="bi bi-person me-2 text-primary"></i>My Profile
              </a>
            </li>
            <li class="mb-3">
              <a href="{{ route('orders.index') }}" class="text-decoration-none">
                <i class="bi bi-cart me-2 text-primary"></i>My Orders
              </a>
            </li>
            <li class="mb-3">
              <a href="#privacy-policy" class="text-decoration-none" onclick="showPrivacyPolicy()">
                <i class="bi bi-shield-check me-2 text-primary"></i>Privacy Policy
              </a>
            </li>
            <li class="mb-3">
              <a href="#terms-of-service" class="text-decoration-none" onclick="showTermsOfService()">
                <i class="bi bi-file-text me-2 text-primary"></i>Terms of Service
              </a>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Emergency Contact -->
      <div class="card support-card">
        <div class="card-header bg-warning">
          <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Emergency Support</h6>
        </div>
        <div class="card-body">
          <p class="mb-2">For urgent technical issues:</p>
          <p class="fw-bold mb-0">emergency@ecoverse.com</p>
          <p class="fw-bold">+256 987 654 321</p>
          <small class="text-muted">Available 24/7</small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleFaq(element) {
  const answer = element.nextElementSibling;
  const icon = element.querySelector('i');
  
  if (answer.style.display === 'block') {
    answer.style.display = 'none';
    icon.className = 'bi bi-plus-circle me-2';
  } else {
    answer.style.display = 'block';
    icon.className = 'bi bi-dash-circle me-2';
  }
}

function showPrivacyPolicy() {
  alert('Privacy Policy\n\nAt Ecoverse, we are committed to protecting your privacy and ensuring the security of your personal information. This policy outlines how we collect, use, and protect your data while using our sustainable supply chain platform.\n\nFor the complete Privacy Policy, please contact our support team.');
}

function showTermsOfService() {
  alert('Terms of Service\n\nWelcome to Ecoverse! By using our platform, you agree to our terms and conditions. Our mission is to promote sustainable practices and eco-friendly commerce.\n\nKey Terms:\n• Respectful use of the platform\n• Commitment to environmental sustainability\n• Fair trading practices\n\nFor complete Terms of Service, please contact our support team.');
}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
