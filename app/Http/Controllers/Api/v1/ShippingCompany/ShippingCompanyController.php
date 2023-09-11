<?php

namespace App\Http\Controllers\Api\v1\ShippingCompany;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Models\ShippingCompany;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;


class ShippingCompanyController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCompany $shippingCompany)
    {
        //
    }
}
