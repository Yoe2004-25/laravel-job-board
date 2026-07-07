<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ApplicationApiController extends Controller
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
    public function index(Request $request)
    {
        $cacheKey = 'application_' . md5($request->collect()->toJson());

        $applications = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Application::with(['user', 'job'])
                ->where('user_id', Auth::id())
                ->latest();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('cv', 'LIKE', "%{$search}%")
                        ->orWhere('status', 'LIKE', "%{$search}%");
                });
            }

            return $query->paginate(10);
        });

        return response()->json([
            'data' => ApplicationResource::collection($applications),
            'message' => 'Success to get data',
            'status' => true,
        ]);
    }

    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

       
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            $validated['cv'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 0;

        $application = Application::create($validated);

        return response()->json([
            'data' => new ApplicationResource($application->load(['user', 'job'])),
            'message' => 'Application stored successfully',
            'status' => true,
        ], 201);
    }

    public function show(string $id)
    {
        $application = Application::where('user_id', Auth::id())
            ->with(['user', 'job'])
            ->find($id);

        if (!$application) {
            return response()->json([
                'status' => false,
                'message' => 'Application not found or not authorized'
            ], 404);
        }

        return response()->json([
            'data' => new ApplicationResource($application),
            'status' => true,
        ]);
    }

    public function update(UpdateApplicationRequest $request, string $id)
    {
        $application = Application::where('user_id', Auth::id())->find($id);

        if (!$application) {
            return response()->json([
                'status' => false,
                'message' => 'Application not found or not authorized'
            ], 404);
        }

        $validated = $request->validated();

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            $validated['cv'] = $path;
        }

        $application->update($validated);

        return response()->json([
            'data' => new ApplicationResource($application->load(['user', 'job'])),
            'message' => 'Application updated successfully',
            'status' => true,
        ]);
    }

    public function destroy(string $id)
    {
        $application = Application::where('user_id', Auth::id())->find($id);

        if (!$application) {
            return response()->json([
                'status' => false,
                'message' => 'Application not found or not authorized'
            ], 404);
        }

        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully',
            'status' => true,
        ]);
    }
}