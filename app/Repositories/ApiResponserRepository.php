<?php

namespace App\Repositories;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Handles api validation error responses
 */
class ApiResponserRepository extends ApiController
{

    public function getErrorResponse($code)
    {
        throw new HttpResponseException(response()->json($this->errorResponse($code))->original);
        // return $this->errorResponse($code);
    }
}
