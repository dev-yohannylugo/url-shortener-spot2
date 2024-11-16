<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "Url Shortener Documentation", title: "Url Shortener Documentation"),
    OA\Server(url: 'http://localhost:8000', description: "local server"),
    OA\SecurityScheme( securityScheme: 'bererAuh', type: 'http', name: 'Authorization', in: 'header', scheme: 'bearer')
]

abstract class Controller
{
    //
}
