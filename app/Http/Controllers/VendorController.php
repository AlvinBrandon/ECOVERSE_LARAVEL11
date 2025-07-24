<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\JavaVendorVerificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VendorController extends Controller
{
    // Show the vendor application form
    public function showApplicationForm()
    {
        return view('vendor.apply');
    }

    // Handle vendor application submission
    public function submitApplication(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required|in:supplier,wholesaler',
            'address' => 'required|string|max:500',
            'tin' => 'required|string|max:100',
            'registration_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'ursb_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'trading_license' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Store the uploaded files
        $documents = [];
        
        // Store Registration Certificate
        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = Str::random(16) . '_registration_' . $file->getClientOriginalName();
            $documents['registration_certificate'] = $file->storeAs('vendors/documents', $fileName, 'public');
        }
        
        // Store URSB Document
        if ($request->hasFile('ursb_document')) {
            $file = $request->file('ursb_document');
            $fileName = Str::random(16) . '_ursb_' . $file->getClientOriginalName();
            $documents['ursb_document'] = $file->storeAs('vendors/documents', $fileName, 'public');
        }
        
        // Store Trading License
        if ($request->hasFile('trading_license')) {
            $file = $request->file('trading_license');
            $fileName = Str::random(16) . '_trading_' . $file->getClientOriginalName();
            $documents['trading_license'] = $file->storeAs('vendors/documents', $fileName, 'public');
        }

        // Schedule a site visit within 24 hours
        $visit = Carbon::now()->addHours(rand(1, 24));

        $vendorApplication = VendorApplication::create([
            'user_id' => Auth::id(),
            'business_name' => $request->name,
            'business_type' => $request->type,
            'business_address' => $request->address,
            'contact_email' => $request->email,
            'contact_phone' => $request->phone ?? '',
            'description' => 'Vendor application submitted via online form',
            'registration_certificate' => $documents['registration_certificate'] ?? null,
            'ursb_document' => $documents['ursb_document'] ?? null,
            'trading_license' => $documents['trading_license'] ?? null,
            'tin' => $request->tin,
            'status' => 'pending',
        ]);

        // Integrate with Java server for document verification
        try {
            // Prepare file paths for Java server validation
            $filePath1 = $request->file('registration_certificate')->getPathname();
            $filePath2 = $request->file('ursb_document')->getPathname();
            $filePath3 = $request->file('trading_license')->getPathname();

            $fileName1 = $documents['registration_certificate'] ? basename($documents['registration_certificate']) : null;
            $fileName2 = $documents['ursb_document'] ? basename($documents['ursb_document']) : null;
            $fileName3 = $documents['trading_license'] ? basename($documents['trading_license']) : null;
            
            // Log file paths for debugging
            \Illuminate\Support\Facades\Log::info('File paths for Java validation', [
                'filePath1' => $filePath1,
                'filePath2' => $filePath2,
                'filePath3' => $filePath3,
                'exists1' => $filePath1 ? file_exists($filePath1) : false,
                'exists2' => $filePath2 ? file_exists($filePath2) : false,
                'exists3' => $filePath3 ? file_exists($filePath3) : false,
            ]);
            
            // Only proceed if we have at least one file to validate
            if ($filePath1 || $filePath2 || $filePath3) {
                $httpRequest = Http::timeout(60)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'User-Agent' => 'Laravel-Ecoverse/1.0'
                    ]);
                
                // Attach files that exist using proper multipart format
                if ($filePath1 && file_exists($filePath1)) {
                    $httpRequest = $httpRequest->attach('file', fopen($filePath1, 'r'), $fileName1);
                }
                if ($filePath2 && file_exists($filePath2)) {
                    $httpRequest = $httpRequest->attach('file', fopen($filePath2, 'r'), $fileName2);
                }
                if ($filePath3 && file_exists($filePath3)) {
                    $httpRequest = $httpRequest->attach('file', fopen($filePath3, 'r'), $fileName3);
                }
                
                // Add additional form data for context
                $httpRequest = $httpRequest
                    ->attach('vendor_name', $request->name)
                    ->attach('vendor_email', $request->email)
                    ->attach('vendor_type', $request->type)
                    ->attach('tin_number', $request->tin);
                
                // Use the correct endpoint
                $javaResponse = $httpRequest->post('http://localhost:8080/validate');
            
                // Log the complete response for debugging
                \Illuminate\Support\Facades\Log::info('Java server response', [
                    'status' => $javaResponse->status(),
                    'headers' => $javaResponse->headers(),
                    'body' => $javaResponse->body(),
                    'vendor_email' => $request->email
                ]);
                
                // Check if the validation was successful
                if ($javaResponse->successful()) {
                    $responseData = $javaResponse->json();
                    
                    // Log the successful verification
                    \Illuminate\Support\Facades\Log::info('Java verification completed successfully', [
                        'vendor_email' => $request->email,
                        'response' => $responseData
                    ]);
                    
                    // Update vendor status and send emails based on Java server response
                    if (isset($responseData['status']) && $responseData['status'] === 'success') {
                        $vendorApplication->status = 'approved';
                        $vendorApplication->save();

                        // Calculate site visit date within 48 working hours
                        $siteVisitDate = $this->calculateSiteVisitDate();
                        
                        // Send success email automatically
                        $this->sendSuccessEmail($vendorApplication, $siteVisitDate);
                        
                        // Return JSON response for successful verification
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Documents verified successfully! Your application has been approved.',
                            'site_visit_date' => $siteVisitDate->format('F j, Y \a\t g:i A'),
                            'additional_info' => 'A confirmation email with site visit details has been sent to your email address.'
                        ]);
                        
                    } elseif (isset($responseData['status']) && $responseData['status'] === 'failed') {
                        $vendorApplication->status = 'rejected';
                        $vendorApplication->save();
                        
                        // Send rejection email automatically
                        $this->sendRejectionEmail($vendorApplication);
                        
                        // Return JSON response for failed verification
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Invalid documents have been detected. Please check your documents and reapply.',
                            'additional_info' => 'A detailed rejection email has been sent to your email address.'
                        ], 400);
                    }
                } else {
                    // Log detailed HTTP error
                    \Illuminate\Support\Facades\Log::error('Java verification HTTP error', [
                        'status_code' => $javaResponse->status(),
                        'response_body' => $javaResponse->body(),
                        'response_headers' => $javaResponse->headers(),
                        'vendor_email' => $request->email,
                        'endpoint' => 'http://localhost:8080/validate'
                    ]);
                    
                    // Keep as pending for manual review
                    $vendorApplication->status = 'pending';
                    $vendorApplication->save();
                    
                    // Send pending email automatically
                    $this->sendPendingEmail($vendorApplication);
                    
                    // Return JSON response for verification service error
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Document verification service is currently unavailable. Your application is pending manual review.',
                        'additional_info' => 'A confirmation email has been sent to your email address.'
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the application
            \Illuminate\Support\Facades\Log::error('Java verification service exception', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'vendor_email' => $request->email
            ]);
            
            // Keep as pending for manual review
            $vendorApplication->status = 'pending';
            $vendorApplication->save();
            
            // Send pending email automatically
            $this->sendPendingEmail($vendorApplication);
            
            // Return JSON response for service exception
            return response()->json([
                'status' => 'pending',
                'message' => 'Document verification service encountered an error. Your application is pending manual review.',
                'additional_info' => 'A confirmation email has been sent to your email address.'
            ]);
        }

        // Fallback: Send pending email if no verification was performed
        $this->sendPendingEmail($vendorApplication);
        
        // Always notify admin about new application
        $this->sendAdminNotification($vendorApplication);

        return response()->json([
            'status' => 'pending',
            'message' => 'Application submitted successfully! We will review your documents and contact you within 24-48 hours.',
            'additional_info' => 'A confirmation email has been sent to your email address.'
        ]);
    }

    // List all vendor applications (admin)
    public function listApplications()
    {
        $vendors = Vendor::orderBy('created_at', 'desc')->get();
        return view('vendor.admin', compact('vendors'));
    }

    // Show a single application (admin)
    public function showApplication($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendor.show', compact('vendor'));
    }

    // Approve a vendor
    public function approve($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = 'approved';
        $vendor->save();
        return redirect()->back()->with('success', 'Vendor approved!');
    }

    // Reject a vendor
    public function reject($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = 'rejected';
        $vendor->save();
        return redirect()->back()->with('success', 'Vendor rejected!');
    }

    // Show the status of the current user's vendor application
    public function showStatus()
    {
        $user = Auth::user();
        $vendor = Vendor::where('email', $user->email)->latest()->first();
        if (!$vendor) {
            return redirect()->route('vendor.apply')->with('error', 'No vendor application found. Please apply first.');
        }
        return view('vendor.status', compact('vendor'));
    }

    /**
     * Calculate site visit date within 48 working hours (excluding weekends)
     */
    private function calculateSiteVisitDate()
    {
        $now = Carbon::now();
        $workingHours = 0;
        $targetHours = 48;
        
        while ($workingHours < $targetHours) {
            $now->addHour();
            
            // Skip weekends (Saturday = 6, Sunday = 0)
            if ($now->dayOfWeek !== Carbon::SATURDAY && $now->dayOfWeek !== Carbon::SUNDAY) {
                // Only count working hours (9 AM to 5 PM)
                if ($now->hour >= 9 && $now->hour < 17) {
                    $workingHours++;
                }
            }
        }
        
        return $now;
    }

    /**
     * Send success email with site visit scheduling
     */
    private function sendSuccessEmail($vendorApplication, $siteVisitDate)
    {
        try {
            $emailContent = "Dear {$vendorApplication->business_name},\n\n";
            $emailContent .= "🎉 CONGRATULATIONS! Your vendor application has been APPROVED! 🎉\n\n";
            $emailContent .= "We are pleased to inform you that your documents have been successfully verified and your application to become a vendor with Ecoverse has been approved.\n\n";
            $emailContent .= "📅 SITE VISIT SCHEDULED:\n";
            $emailContent .= "Date & Time: {$siteVisitDate->format('F j, Y \a\t g:i A')}\n";
            $emailContent .= "Location: {$vendorApplication->business_address}\n\n";
            $emailContent .= "📋 WHAT TO EXPECT:\n";
            $emailContent .= "• Our team will contact you 24 hours before the scheduled visit\n";
            $emailContent .= "• The visit will take approximately 1-2 hours\n";
            $emailContent .= "• Please have your original documents ready for verification\n";
            $emailContent .= "• Ensure your business premises are accessible\n\n";
            $emailContent .= "📞 CONTACT INFORMATION:\n";
            $emailContent .= "If you need to reschedule or have any questions, please contact us at:\n";
            $emailContent .= "Phone: 0791199978\n";
            $emailContent .= "Email: vendors@ecoverse.com\n\n";
            $emailContent .= "Welcome to the Ecoverse family!\n\n";
            $emailContent .= "Best regards,\n";
            $emailContent .= "The Ecoverse Vendor Relations Team";

            Mail::raw($emailContent, function ($message) use ($vendorApplication) {
                $message->to($vendorApplication->contact_email)
                        ->subject('🎉 Vendor Application APPROVED - Site Visit Scheduled - Ecoverse');
            });

            \Illuminate\Support\Facades\Log::info('Success email sent successfully', [
                'vendor_email' => $vendorApplication->contact_email,
                'business_name' => $vendorApplication->business_name
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send success email', [
                'error' => $e->getMessage(),
                'vendor_email' => $vendorApplication->contact_email
            ]);
        }
    }

    /**
     * Send rejection email with detailed feedback
     */
    private function sendRejectionEmail($vendorApplication)
    {
        try {
            $emailContent = "Dear {$vendorApplication->business_name},\n\n";
            $emailContent .= "Thank you for your interest in becoming a vendor with Ecoverse.\n\n";
            $emailContent .= "❌ APPLICATION STATUS: REJECTED\n\n";
            $emailContent .= "Unfortunately, we were unable to verify the documents you submitted. Our automated verification system has detected issues with one or more of your documents.\n\n";
            $emailContent .= "🔍 POSSIBLE ISSUES DETECTED:\n";
            $emailContent .= "• Document authenticity concerns\n";
            $emailContent .= "• Unclear or unreadable document quality\n";
            $emailContent .= "• Missing required information\n";
            $emailContent .= "• Document format or type issues\n\n";
            $emailContent .= "📋 REQUIRED DOCUMENTS CHECKLIST:\n";
            $emailContent .= "✓ Business Registration Certificate (clear, original)\n";
            $emailContent .= "✓ URSB Document (valid and up-to-date)\n";
            $emailContent .= "✓ Trading License (current and readable)\n\n";
            $emailContent .= "🔄 NEXT STEPS:\n";
            $emailContent .= "You are welcome to reapply with corrected documents. Please ensure:\n";
            $emailContent .= "• All documents are original and unmodified\n";
            $emailContent .= "• Images/scans are clear and readable\n";
            $emailContent .= "• All documents are valid and up-to-date\n";
            $emailContent .= "• File formats are PDF, JPG, JPEG, or PNG\n\n";
            $emailContent .= "📞 NEED HELP?\n";
            $emailContent .= "If you believe this is an error or need assistance, please contact:\n";
            $emailContent .= "Phone: 0791199978\n";
            $emailContent .= "Email: support@ecoverse.com\n\n";
            $emailContent .= "We appreciate your interest in partnering with Ecoverse.\n\n";
            $emailContent .= "Best regards,\n";
            $emailContent .= "The Ecoverse Vendor Relations Team";

            Mail::raw($emailContent, function ($message) use ($vendorApplication) {
                $message->to($vendorApplication->contact_email)
                        ->subject('❌ Vendor Application - Document Verification Failed - Ecoverse');
            });

            \Illuminate\Support\Facades\Log::info('Rejection email sent successfully', [
                'vendor_email' => $vendorApplication->contact_email,
                'business_name' => $vendorApplication->business_name
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send rejection email', [
                'error' => $e->getMessage(),
                'vendor_email' => $vendorApplication->contact_email
            ]);
        }
    }

    /**
     * Send pending review email
     */
    private function sendPendingEmail($vendorApplication)
    {
        try {
            $emailContent = "Dear {$vendorApplication->business_name},\n\n";
            $emailContent .= "Thank you for submitting your vendor application with Ecoverse!\n\n";
            $emailContent .= "📋 APPLICATION STATUS: PENDING REVIEW\n\n";
            $emailContent .= "We have successfully received your application and documents. Your application is currently in our review queue for manual verification.\n\n";
            $emailContent .= "⏰ EXPECTED TIMELINE:\n";
            $emailContent .= "• Initial review: 24-48 hours\n";
            $emailContent .= "• Document verification: 2-3 business days\n";
            $emailContent .= "• Final decision: Within 5 business days\n\n";
            $emailContent .= "📄 SUBMITTED DOCUMENTS:\n";
            $emailContent .= "✓ Business Registration Certificate\n";
            $emailContent .= "✓ URSB Document\n";
            $emailContent .= "✓ Trading License\n\n";
            $emailContent .= "📞 WHAT'S NEXT?\n";
            $emailContent .= "• Our verification team will review your documents\n";
            $emailContent .= "• You will receive email updates on your application status\n";
            $emailContent .= "• If approved, we will schedule a site visit\n";
            $emailContent .= "• If additional information is needed, we will contact you\n\n";
            $emailContent .= "📧 STAY UPDATED:\n";
            $emailContent .= "You can check your application status anytime by logging into your account.\n\n";
            $emailContent .= "📞 CONTACT US:\n";
            $emailContent .= "Phone: 0791199978\n";
            $emailContent .= "Email: vendors@ecoverse.com\n\n";
            $emailContent .= "We appreciate your patience during the review process.\n\n";
            $emailContent .= "Best regards,\n";
            $emailContent .= "The Ecoverse Vendor Relations Team";

            Mail::raw($emailContent, function ($message) use ($vendorApplication) {
                $message->to($vendorApplication->contact_email)
                        ->subject('📋 Vendor Application Received - Pending Review - Ecoverse');
            });

            \Illuminate\Support\Facades\Log::info('Pending email sent successfully', [
                'vendor_email' => $vendorApplication->contact_email,
                'business_name' => $vendorApplication->business_name
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send pending email', [
                'error' => $e->getMessage(),
                'vendor_email' => $vendorApplication->contact_email
            ]);
        }
    }

    /**
     * Send admin notification email
     */
    private function sendAdminNotification($vendorApplication)
    {
        try {
            $emailContent = "A new vendor application has been submitted:\n\n";
            $emailContent .= "Business Name: {$vendorApplication->business_name}\n";
            $emailContent .= "Business Type: {$vendorApplication->business_type}\n";
            $emailContent .= "Contact Email: {$vendorApplication->contact_email}\n";
            $emailContent .= "TIN: {$vendorApplication->tin}\n";
            $emailContent .= "Status: {$vendorApplication->status}\n";
            $emailContent .= "Submitted: " . $vendorApplication->created_at->format('F j, Y \a\t g:i A') . "\n\n";
            $emailContent .= "Please review the application in the admin panel.";

            Mail::raw($emailContent, function ($message) {
                $message->to('ecoverseltd0@gmail.com') // Changed to your email
                        ->subject('🔔 New Vendor Application Submitted - Ecoverse');
            });

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send admin notification email', [
                'error' => $e->getMessage()
            ]);
        }
    }
}