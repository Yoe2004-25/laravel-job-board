<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Jobs;
use App\Models\User;
use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobApiController extends Controller
{
    
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
    public function index(Request $request)
    {
        $cacheKey = 'jobs_' . md5(json_encode($request->all()));
        
        $jobs = Cache::remember($cacheKey, 60, function () use ($request) {
            $query = Jobs::query()->with(['user', 'company', 'applications'])
                ->latest();

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('location', 'like', "%$search%")
                        ->orWhere('salary', 'like', "%$search%");
                });
            }

            return $query->paginate(10);
        });

        return response()->json([
            'data' => JobResource::collection($jobs),
            'message' => 'Jobs retrieved successfully',
            'status' => true,
        ]);
    }

    public function store(StoreJobRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $job = Jobs::create($data);

        return response()->json([
            'data' => new JobResource($job->load(['user', 'company'])),
            'message' => 'Job created successfully',
            'status' => true,
        ], 201);
    }

    public function show(string $id)
    {
        $job = Jobs::with(['user', 'company', 'applications'])->findOrFail($id);
        
        return response()->json([
            'data' => new JobResource($job),
            'message' => 'Job retrieved successfully',
            'status' => true,
        ]);
    }

    public function update(UpdateJobRequest $request, string $id)
    {
        $job = Jobs::findOrFail($id);
        $this->authorize('update', $job);
        
        $job->update($request->validated());

        return response()->json([
            'data' => new JobResource($job->load(['user', 'company'])),
            'message' => 'Job updated successfully',
            'status' => true,
        ]);
    }

    public function destroy(string $id)
    {
        $job = Jobs::findOrFail($id);
        $this->authorize('delete', $job);
        
        $job->delete();

        Cache::forget('jobs_' . $id);

        return response()->json([
            'message' => 'Job deleted successfully',
            'status' => true,
        ]);
    }
}