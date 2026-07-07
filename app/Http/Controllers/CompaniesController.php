<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\User;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;
use Illuminate\Http\Request;
use App\Events\CompaniesRegister;
class CompaniesController extends Controller
{
    public function index()
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
        $companies = Companies::with(['user', 'jobs'])
            ->latest()
            ->paginate(10);

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        $users = User::all();
        return view('companies.create', compact('users'));
    }

    public function store(StoreCompaniesRequest $request)
    {
        $validated = $request->validated();
        $companies = Companies::create($validated);

        CompaniesRegister::dispatch($companies);
        
        return redirect()
            ->route('companies.index')
            ->with('success', 'Company created successfully!');
    }

    public function show($id)
    {
    $companies = Companies::with(['user', 'jobs'])->findOrFail($id);
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $companies = Companies::findOrFail($id);
        $users = User::all();
        return view('companies.edit', compact('company', 'users'));
    }

    public function update(UpdateCompaniesRequest $request, $id)
    {
        $companies = Companies::findOrFail($id);
        $validated = $request->validated();
        $companies->update($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company updated successfully!');
    }

    public function destroy($id)
    {
        $companies = Companies::findOrFail($id);
        $companies->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully!');
    }
}