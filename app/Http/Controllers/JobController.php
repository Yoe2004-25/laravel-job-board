<?php

namespace App\Http\Controllers;

use App\Models\jobs;
use App\Models\User;
use App\Models\Companies;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Events\JobRegister; 
class JobController extends Controller
{
    public function index(Request $request)
    {
    
        
        $jobs = jobs::with(['company', 'user'])
            ->filter($request->all())
            ->latest()
            ->paginate(10);

        $query  =  jobs::query() ; 

        if ($request->has('search'))
        {
            $search = $request->search ; 

            $query->where(function ($q) use ($search) 
            {
              $q->where('name','LIKE',"%$search%")   
                    ->orwhere('description', 'LIKE' , "%$search%")
                    ->orwhere('salary', 'LIKe', "%$search")
                    ->orwhere('location','LIKE',"%$search%");
            });
        }

        $query->paginate(10) ; 

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        $users = User::all();
        $companies = Companies::all();
        return view('jobs.create', compact('users', 'companies'));
    }

    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();
        $jobs = jobs::create($validated);

        event(new JobRegister($jobs));  
        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job created successfully!');
    }

    public function show($id)
    {
        $job = jobs ::with(['company', 'user', 'applications'])->findOrFail($id);
        return view('jobs.show', compact('job'));
    }

    public function edit($id)
    {
        $jobs = jobs::findOrFail($id);
        $users = User::all();
        $companies = Companies::all();
        return view('jobs.edit', compact('job', 'users', 'companies'));
    }

    public function update(UpdateJobRequest $request, $id)
    {
        $jobs = jobs::findOrFail($id);
        $validated = $request->validated();
        $jobs->update($validated);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        $jobs = jobs::findOrFail($id);
        $jobs->delete();

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}