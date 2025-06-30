<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
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
            'ursb_document' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'address' => 'required|string|max:255',
            'tin' => 'required|string|max:100',
        ]);

        // Store the uploaded file
        $file = $request->file('ursb_document');
        $fileName = Str::random(16) . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('vendors', $fileName, 'public');

        // Schedule a site visit within 24 hours
        $visit = Carbon::now()->addHours(rand(1, 24));

        $vendor = Vendor::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'ursb_document' => $filePath,
            'address' => $request->address,
            'tin' => $request->tin,
            'status' => 'pending',
            'scheduled_visit' => $visit,
        ]);

        // Integrate with Java server for URSB verification
        $javaService = new JavaVendorVerificationService();
        $javaResponse = $javaService->verifyUrsb($fileName, $request->email, $request->name);

        // Optionally update vendor status based on Java server response
        if (isset($javaResponse['status']) && $javaResponse['status'] === 'success') {
            $vendor->status = 'verified';
            $vendor->save();
        }

        // Send confirmation email to applicant
        Mail::raw(
            "Thank you for your application. Your site visit is scheduled for: " . $visit->toDayDateTimeString(),
            function ($message) use ($vendor) {
                $message->to($vendor->email)
                        ->subject('Site Visit Scheduled');
            }
        );

        // Notify admin (email)
        Mail::raw(
            "A new vendor application has been submitted by {$vendor->name} ({$vendor->email}).",
            function ($message) {
                $message->to('admin@yourcompany.com')
                        ->subject('New Vendor Application');
            }
        );

        return redirect()->route('vendor.apply')->with('success', 'Application submitted! Check your email for confirmation. Java server response: ' . ($javaResponse['message'] ?? 'No response'));
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