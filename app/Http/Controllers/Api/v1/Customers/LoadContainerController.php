<?php

namespace App\Http\Controllers\Api\v1\Customers;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;

class LoadContainerController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

}
