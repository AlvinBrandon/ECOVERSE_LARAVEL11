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

  .settings-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: none;
    margin-bottom: 2rem;
  }

  .settings-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
  }

  .settings-card .card-body {
    padding: 1.5rem;
  }

  .form-check-input {
    background-color: #e5e7eb;
    border-color: #d1d5db;
    border-radius: 1rem;
    width: 2.5rem;
    height: 1.25rem;
  }

  .form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
  }

  .setting-item {
    border-bottom: 1px solid #f3f4f6;
    padding: 1rem 0;
  }

  .setting-item:last-child {
    border-bottom: none;
  }

  .danger-zone {
    border: 2px solid #ef4444;
    border-radius: 1rem;
    background: #fef2f2;
  }
</style>

<div class="container-fluid py-4">
  <!-- Page Header -->
  <div class="page-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h4><i class="bi bi-gear me-2"></i>Account Settings</h4>
        <p class="mb-0 opacity-75">Manage your account preferences and security settings</p>
      </div>
      <a href="{{ route('profile') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-1"></i>Back to Profile
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Notification Settings -->
    <div class="col-md-6 mb-4">
      <div class="card settings-card">
        <div class="card-header">
          <h6><i class="bi bi-bell me-2"></i>Notification Preferences</h6>
        </div>
        <div class="card-body">
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Email Notifications</strong>
                <p class="text-muted mb-0 small">Receive updates via email</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="emailNotif" checked>
              </div>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Order Updates</strong>
                <p class="text-muted mb-0 small">Get notified about order status</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="orderNotif" checked>
              </div>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Marketing Communications</strong>
                <p class="text-muted mb-0 small">Receive promotional emails</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="marketingNotif">
              </div>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Weekly Reports</strong>
                <p class="text-muted mb-0 small">Sustainability impact summaries</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="weeklyReports" checked>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Privacy Settings -->
    <div class="col-md-6 mb-4">
      <div class="card settings-card">
        <div class="card-header">
          <h6><i class="bi bi-shield-lock me-2"></i>Privacy & Security</h6>
        </div>
        <div class="card-body">
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Public Profile</strong>
                <p class="text-muted mb-0 small">Make your profile visible to others</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="publicProfile">
              </div>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Data Analytics</strong>
                <p class="text-muted mb-0 small">Help improve our services</p>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="dataAnalytics" checked>
              </div>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Two-Factor Authentication</strong>
                <p class="text-muted mb-0 small">Extra security for your account</p>
              </div>
              <button class="btn btn-outline-primary btn-sm">Setup</button>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Change Password</strong>
                <p class="text-muted mb-0 small">Update your account password</p>
              </div>
              <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Eco Preferences -->
    <div class="col-md-6 mb-4">
      <div class="card settings-card">
        <div class="card-header">
          <h6><i class="bi bi-leaf me-2"></i>Eco Preferences</h6>
        </div>
        <div class="card-body">
          <div class="setting-item">
            <label class="form-label">Preferred Shipping Method</label>
            <select class="form-select">
              <option>Carbon Neutral Shipping</option>
              <option>Standard Shipping</option>
              <option>Express Shipping</option>
            </select>
          </div>
          
          <div class="setting-item">
            <label class="form-label">Packaging Preference</label>
            <select class="form-select">
              <option>Biodegradable Only</option>
              <option>Recyclable Materials</option>
              <option>Minimal Packaging</option>
              <option>No Preference</option>
            </select>
          </div>
          
          <div class="setting-item">
            <label class="form-label">Carbon Offset Contribution</label>
            <select class="form-select">
              <option>Automatic (5% of order)</option>
              <option>Custom Amount</option>
              <option>Opt Out</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Account Management -->
    <div class="col-md-6 mb-4">
      <div class="card settings-card">
        <div class="card-header">
          <h6><i class="bi bi-person-gear me-2"></i>Account Management</h6>
        </div>
        <div class="card-body">
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Download My Data</strong>
                <p class="text-muted mb-0 small">Get a copy of your account data</p>
              </div>
              <button class="btn btn-outline-info btn-sm">Download</button>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Account Backup</strong>
                <p class="text-muted mb-0 small">Backup your preferences</p>
              </div>
              <button class="btn btn-outline-success btn-sm">Backup</button>
            </div>
          </div>
          
          <div class="setting-item">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <strong>Deactivate Account</strong>
                <p class="text-muted mb-0 small">Temporarily disable your account</p>
              </div>
              <button class="btn btn-outline-warning btn-sm">Deactivate</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Danger Zone -->
  <div class="row">
    <div class="col-12">
      <div class="card danger-zone">
        <div class="card-header bg-transparent border-0">
          <h6 class="text-danger mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
        </div>
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <strong class="text-danger">Delete Account</strong>
              <p class="text-muted mb-0">Permanently delete your account and all data. This action cannot be undone.</p>
            </div>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Update Password</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Delete Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>This action cannot be undone.</strong></p>
        <p>Deleting your account will:</p>
        <ul>
          <li>Remove all your personal data</li>
          <li>Cancel any active orders</li>
          <li>Delete your eco-progress history</li>
          <li>Remove your vendor partnerships (if any)</li>
        </ul>
        <div class="mb-3">
          <label class="form-label">Type "DELETE" to confirm:</label>
          <input type="text" class="form-control" id="deleteConfirmation">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDelete" disabled>Delete Account</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle settings switches
    const switches = document.querySelectorAll('.form-check-input');
    
    switches.forEach(switch_ => {
        switch_.addEventListener('change', function() {
            const settingName = this.id;
            const isEnabled = this.checked;
            
            // Show confirmation for important settings
            if (settingName === 'publicProfile' && isEnabled) {
                if (!confirm('Making your profile public will allow other users to see your eco-impact. Continue?')) {
                    this.checked = false;
                    return;
                }
            }
            
            // Save setting (you can implement AJAX here)
            console.log(`Setting ${settingName} changed to ${isEnabled}`);
            
            // Show toast notification
            showToast(`Setting updated: ${settingName}`, 'success');
        });
    });
    
    // Handle delete confirmation
    const deleteInput = document.getElementById('deleteConfirmation');
    const confirmButton = document.getElementById('confirmDelete');
    
    deleteInput.addEventListener('input', function() {
        confirmButton.disabled = this.value !== 'DELETE';
    });
    
    confirmButton.addEventListener('click', function() {
        alert('Account deletion would be processed here. This is a demo.');
    });
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
