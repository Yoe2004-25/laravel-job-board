<?php

namespace App\Http\Controllers;
use App\Models\Jobs;
/**
 * @OA\Info(
 *     title="Job API",
 *     version="1.0.0",
 *     description="Api Swaaager Job board Api"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * @OA\Get(
 *     path="/api/jobs",
 *     summary="عرض كل الوظائف",
 *     tags={"Jobs"},
 *     @OA\Response(
 *         response=200,
 *         description="نجاح العملية"
 *     )
 */
class SwaggerController extends Controller 
{
      public function index() 
      {
            return Jobs::all() ; 
      }
}