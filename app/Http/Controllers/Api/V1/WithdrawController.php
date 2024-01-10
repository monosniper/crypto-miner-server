<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Resources\WithdrawResource;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        // Fake withdraws
        // $withdraws = Withdraw::all()->load('nfts');

        $withdraws = [];

        $user_ids = User::pluck('id')->toArray();

        for ($i=0; $i < 100; $i++) {
            $withdraws[] = new Withdraw([
                'status' => Withdraw::STATUS_SUCCESS,
                'amount' => rand(100, 1000),
                'user_id' => $user_ids[array_rand($user_ids)],
            ]);
        }

        return WithdrawResource::collection($withdraws);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request): WithdrawResource
    {
        $withdraw = Withdraw::create($request->validated());

        return new WithdrawResource($withdraw);
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
