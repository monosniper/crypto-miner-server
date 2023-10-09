<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConvertationResource;
use App\Models\Convertation;
use Illuminate\Http\Request;

class ConvertationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $convertations = Convertation::all();
        $collection = ConvertationResource::collection($convertations);

        return response()->json($collection);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
