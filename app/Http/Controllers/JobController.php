<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Company;
use App\Models\JobApplication;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobsQuery = JobListing::with('company')
            ->orderByRaw('CASE WHEN featured_until >= ? THEN 1 ELSE 0 END DESC', [now()->toDateTimeString()])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $jobsQuery->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('company', function($cQ) use ($search) {
                      $cQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('remote')) {
            $jobsQuery->where('remote', true);
        }

        if ($request->filled('location')) {
            $jobsQuery->where('location', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->filled('type')) {
            $jobsQuery->where('type', $request->input('type'));
        }

        if ($request->filled('date_posted')) {
            $datePosted = $request->input('date_posted');
            if ($datePosted === '24h') {
                $jobsQuery->where('created_at', '>=', now()->subDay());
            } elseif ($datePosted === 'week') {
                $jobsQuery->where('created_at', '>=', now()->subWeek());
            } elseif ($datePosted === 'month') {
                $jobsQuery->where('created_at', '>=', now()->subMonth());
            }
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            if ($role === 'ai-engineer') {
                $jobsQuery->where(function($q) {
                    $q->where('title', 'like', '%AI%')
                      ->orWhere('title', 'like', '%Artificial Intelligence%')
                      ->orWhere('title', 'like', '%NLP%');
                });
            } elseif ($role === 'ml-engineer') {
                $jobsQuery->where(function($q) {
                    $q->where('title', 'like', '%ML%')
                      ->orWhere('title', 'like', '%Machine Learning%')
                      ->orWhere('title', 'like', '%Deep Learning%')
                      ->orWhere('title', 'like', '%Computer Vision%');
                });
            } elseif ($role === 'prompt-engineer') {
                $jobsQuery->where('title', 'like', '%Prompt%');
            } elseif ($role === 'data-engineer') {
                $jobsQuery->where('title', 'like', '%Data%');
            }
        }

        $jobs = $jobsQuery->get();
        $activeRole = $request->input('role');

        $myApplications = auth()->check()
            ? JobApplication::where('user_id', auth()->id())->pluck('job_listing_id')->toArray()
            : [];

        $myJobs = [];
        if (auth()->check()) {
            $myJobs = JobListing::where('posted_by', auth()->id())
                ->with(['applications.applicant.profile', 'applications.applicant'])
                ->latest()
                ->get();
        }

        return view('jobs.index', compact('jobs', 'activeRole', 'myApplications', 'myJobs'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('jobs.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:100',
            'remote' => 'nullable|boolean',
            'type' => 'required|in:Full-time,Part-time,Contract,Freelance,Remote',
            'description' => 'required|string',
            'apply_url' => 'nullable|url|max:255',
            'salary_range' => 'nullable|string|max:100',
        ]);

        // Create or find company
        $company = Company::firstOrCreate(
            ['name' => $request->company_name],
            ['website' => $request->company_website, 'user_id' => auth()->id()]
        );

        JobListing::create([
            'title' => $request->title,
            'company_id' => $company->id,
            'location' => $request->location,
            'remote' => (bool) $request->input('remote', false),
            'type' => $request->type,
            'description' => $request->description,
            'apply_url' => $request->apply_url,
            'salary_range' => $request->salary_range,
            'posted_by' => auth()->id(),
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    public function show(JobListing $job)
    {
        $job->load('company');

        return view('jobs.show', compact('job'));
    }

    public function apply(Request $request, JobListing $job)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to apply.');
        }

        // Check if already applied
        $existing = JobApplication::where('job_listing_id', $job->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        JobApplication::create([
            'job_listing_id' => $job->id,
            'user_id' => auth()->id(),
            'cover_letter' => $request->input('cover_letter'),
        ]);

        return back()->with('success', 'Application submitted successfully! The poster will review your profile.');
    }
}
