<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\JobListing;

class PremiumController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Fetch approved products owned by the user
        $myProducts = Product::where('user_id', $user->id)
            ->where('status', 'approved')
            ->withCount(['votes', 'comments'])
            ->get();

        // Fetch jobs posted by the user
        $myJobs = JobListing::where('posted_by', $user->id)
            ->get();

        return view('premium.index', compact('user', 'myProducts', 'myJobs'));
    }

    public function upgrade(Request $request)
    {
        $user = auth()->user();
        $user->update(['is_premium' => true]);

        return redirect()->route('premium.index')
            ->with('success', 'Thank you! You are now a Premium Member of ArrayType 💎');
    }

    public function promote(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'package' => 'required|in:starter,pro,elite',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Authorization check
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Apply package features
        // starter: 1-Day Category Pin
        // pro: 7-Day Category Pin (we store as category pin for 7 days)
        // elite: 30-Day Category Pin (we store as category pin for 30 days)
        // Note: For pro and elite, we can also give homepage pin time as a premium override
        switch ($request->package) {
            case 'starter':
                $product->update([
                    'pin_type' => 'category',
                    'pinned_until' => now()->addDay(),
                ]);
                $packageName = 'Starter Promo (1-Day Category Pin)';
                break;
            case 'pro':
                $product->update([
                    'pin_type' => 'homepage',
                    'pinned_until' => now()->addDays(1),
                ]);
                $packageName = 'Pro Promo (1-Day Homepage Pin)';
                break;
            case 'elite':
                $product->update([
                    'pin_type' => 'homepage',
                    'pinned_until' => now()->addDays(7),
                ]);
                $packageName = 'Elite Promo (7-Day Homepage Pin)';
                break;
        }

        return redirect()->route('premium.index')
            ->with('success', "Promotion successfully activated: {$packageName}! 🚀");
    }

    public function updateCta(Request $request, Product $product)
    {
        $user = auth()->user();
        
        if (!$user->is_premium) {
            return back()->with('error', 'Only premium users can customize the Call-To-Action.');
        }

        if ($product->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'custom_cta_text' => 'nullable|string|max:40',
        ]);

        $product->update([
            'custom_cta_text' => $request->custom_cta_text,
        ]);

        return redirect()->route('premium.index')
            ->with('success', 'Custom Call-To-Action updated successfully!');
    }

    public function promoteJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_listings,id',
            'package' => 'required|in:weekly,monthly',
        ]);

        $job = JobListing::findOrFail($request->job_id);

        if ($job->posted_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->package === 'weekly') {
            $job->update([
                'featured_until' => now()->addDays(7),
            ]);
            $packageName = 'Weekly Job Booster (7 Days)';
        } else {
            $job->update([
                'featured_until' => now()->addDays(30),
            ]);
            $packageName = 'Monthly Job Booster (30 Days)';
        }

        return redirect()->route('premium.index')
            ->with('success', "Job promotion successfully activated: {$packageName}! 🚀");
    }
}
