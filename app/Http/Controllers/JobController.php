<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Company;

class JobController extends Controller
{
    public function index()
    {
        $jobsQuery = JobListing::with('company')->latest();

        if (request()->filled('remote')) {
            $jobsQuery->where('remote', true);
        }

        if (request()->filled('location')) {
            $jobsQuery->where('location', 'like', '%' . request('location') . '%');
        }

        if (request()->filled('type')) {
            $jobsQuery->where('type', request('type'));
        }

        $jobs = $jobsQuery->get();
        return view('jobs.index', compact('jobs'));
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
}
