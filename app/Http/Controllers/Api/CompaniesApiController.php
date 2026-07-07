<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesResource;
use App\Models\Companies;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;



class CompaniesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // the Model Elemts in Companies 

    // ['name' , 'number_employess','website_name','number_phone' , 'id_manager'] ; 

    /**
 * @OA\Get(
 *     path="/api/jobs",
 *     summary="Get all jobs",
 *     tags={"Jobs"},
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     )
 * /**
 * 
 *     )
 * )
 */


    public $companies ; 
    public function index(Request $request)
    {
           $cachekey = 'companies_'.md5(json_decode($request->all())) ; 

           $companies = Cache::remember($cachekey , 600 , function () use ($request)
           {
                    $companies = Companies::where('user_id' , Auth::id())
                    ->with(['user','job'])
                    ->latest()
                    ->paginate(10) ; 

                    $query = Companies::query() ;

                    if ($request->has('search'))
                    {
                        $search = $request->search ; 
                        $query->where(function ($q) use($search)
                        {
                                $q->where('name','like',"%$search%")
                                    ->orwhere('website_name','like',"%$search%")
                                    ->orwhere('number_phone','like',"%$search%");
                        });
                                 
                        
                    }
            
                    // Sorting 
           });
        
          return response()->json(Companies::newCollection($companies)) ; 
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompaniesRequest $request)
    {
        
        $data = $request->validated() ; 
        

        $companies = Companies::where('user_id' , Auth::id()); 
        
        
        $companies = Companies::create($data) ; 


        if(!$companies)
        {
            return response()->json([
                'message'=>'the data is wrong',
                'status'=>false , 
            ]);
        }


        return response()->json([
            new CompaniesResource($companies) , 
            'message'=>'the store of data success', 
            'status'=>true , 
            'data'=>$companies , 
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $companies = Companies::where('user_id' , Auth::id())->find($id)->with(['user' , 'jobs']); 
        
        if (!$companies)
        {
            return response([
                'message'=>'the data is Wrong can not to created', 
                'status'=>false, 
            ]);
        }

        return response()->json([
            'message'=>'the data is showed' , 
            'data' => $companies , 
            'status'=> true , 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompaniesRequest $request, string $id)
    {
        
        $companies = Companies::where(['user_id' , Auth::id()])->findOrNew($id) ;   
        $data = $request->validated();
        
        if (!$companies) 
        {
            return response()->json([
                'messsage'=>'the data is updated', 
                'status' => false , 
            ]);
        }
        $companies->update($data); 
        return response()->json([
            'message'=>'the data is updated in Company',
            'data'=>$data , 
            'status'=>true, 
            new CompaniesResource($companies),
        ]);

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companies = Companies::find($id); 

        $companies->delete(); 

        return response()->json([
            'message'=>'the Deletion of Data is done' ,
        ]);
    }
}