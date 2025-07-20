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

        // Integrate with Java server for URSB verification (if service exists)
        try {
            $javaService = new JavaVendorVerificationService();
            $javaResponse = $javaService->verifyUrsb($documents['ursb_document'] ?? '', $request->email, $request->name);

            // Optionally update vendor status based on Java server response
            if (isset($javaResponse['status']) && $javaResponse['status'] === 'success') {
                $vendorApplication->status = 'verified';
                $vendorApplication->save();
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the application
            \Illuminate\Support\Facades\Log::warning('Java verification service failed: ' . $e->getMessage());
        }

        // Send confirmation email to applicant
        Mail::raw(
            "Thank you for your vendor application. We will review your documents and get back to you within 24-48 hours.",
            function ($message) use ($vendorApplication) {
                $message->to($vendorApplication->contact_email)
                        ->subject('Vendor Application Received - Ecoverse');
            }
        );

        // Notify admin (email)
        Mail::raw(
            "A new vendor application has been submitted by {$vendorApplication->business_name} ({$vendorApplication->contact_email}).",
            function ($message) {
                $message->to('admin@ecoverse.com')
                        ->subject('New Vendor Application - Ecoverse');
            }
        );

        return redirect()->route('vendor.apply')->with('success', 'Application submitted successfully! We will review your documents and contact you within 24-48 hours.');
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
} 