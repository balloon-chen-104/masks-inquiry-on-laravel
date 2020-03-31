<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CallApiException extends Exception
{
    private $apiName;
    
    public function __construct($apiName)
    {
        $this->apiName = $apiName;
    }

    public function render()
    {
        return JsonResponse::create([
            "exception type: " => "CallApiException",
            "exception name: " => "$this->apiName",
            "error message: " => "API Connection Error, Please Try Again!"
        ]);
    }
}
