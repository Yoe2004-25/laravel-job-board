<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\User;
use App\Models\jobs;
use Illuminate\Http\Request;
class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/api/jobs",
 *     summary="Get all jobs",
 *     tags={"Jobs"},
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     )
 * )
 */

    // ['title', 'cv', 'status', 'user_id', 'job_id'];
    public function index(Request $request)
    {
        $query =  Application::query()->with(['user','job'])
        ->first();

        if ( $request->has('search'))
        {
            $search = $request->search ; 
            
            $query->where(function ($q) use($search) 
            {
                    $q->where('title','LIKE',"%$search%")  
                        ->orwhere('status','LIKe',"%$search%")  
                        ->orwhere('cv','LIKE',"%$search%");
            });

             
        }

        $application = $query->paginate(10) ;  
           
            
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $users = User::all();
        $jobs = jobs::all();
        return view('applications.create', compact('users', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();
        
       
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            $validated['cv'] = $path;
        }

        $application = Application::create($validated);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Application submitted successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $application = Application::with(['user', 'job'])->findOrFail($id);
        return view('applications.show', compact('application'));
    }

    public function edit($id)
    {
        $application = Application::findOrFail($id);
        $users = User::all();
        $jobs = jobs::all();
        return view('applications.edit', compact('application', 'users', 'jobs'));
    }

    public function update(UpdateApplicationRequest $request, $id)
    {
        $application = Application::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            $validated['cv'] = $path;
        }

        $application->update($validated);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Application updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application  , $id)
    {
        $application = Application::findOrFail($id) ; 
        
        $application->delete(); 

        return redirect()
        ->route('applications.index',compact($application));
    }
}