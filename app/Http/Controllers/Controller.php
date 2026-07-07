<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "My Laravel API Documentation",
    version: "1.0.0",
    description: "This is the API documentation for my project job board Api."
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local Development Server"
)]
abstract class Controller
{
    
}