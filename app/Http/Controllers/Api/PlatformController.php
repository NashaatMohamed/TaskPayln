<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{

    public function index() : JsonResponse
    {
        $platforms = Platform::active()->get();
        return $this->dataResponse(msg: "the active platforms", data: PlatformResource::collection($platforms));
    }

    public function toggleActive(Platform $platform): JsonResponse
    {
        $platform->toggleActivation();
        return $this->dataResponse(msg: "the platform status changed", data: PlatformResource::make($platform));
    }


}
