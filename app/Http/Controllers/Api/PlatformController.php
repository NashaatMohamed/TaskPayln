<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{

    public function index() : JsonResponse
    {
        $platforms = Platform::active()->get();
        return $this->dataResponse(msg: "the active platforms", data: $platforms);
    }

    public function toggleActive(Platform $platform): JsonResponse
    {
        $platform->toggleActivation();
        $data = [
            'platform' => $platform,
            'status_label' => $platform->getActiveStatus()->label(),
        ];
        return $this->dataResponse(msg: "the active platforms", data: $data);
    }


}
