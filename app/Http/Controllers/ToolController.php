<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::latest()->get();
        return view('tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        return view('tools.show', compact('tool'));
    }

    public function create()
    {
        return view('tools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description' => 'required|string|max:2000',
            'category' => 'required|string|max:100',
            'logo' => 'nullable|url|max:255',
        ]);

        Tool::create([
            'name' => $request->name,
            'url' => $request->url,
            'description' => $request->description,
            'category' => $request->category,
            'logo' => $request->logo,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tools.index')->with('success', 'Tool submitted successfully! Thank you for contributing.');
    }
}
