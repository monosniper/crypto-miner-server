<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\SessionStart;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSessionRequest;
use App\Http\Resources\SessionResource;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function start(Request $request): \Illuminate\Http\JsonResponse
    {
        $session = Session::create([
            'user_id' => $request->input('user_id')
        ]);

        $session->coins()->sync($request->input('coins'));
        $session->user_servers()->sync($request->input('servers'));

//        event(new SessionStart($session));

        return response()->json([
            'success' => true,
            'data' => new SessionResource($session)
        ]);
    }

    public function show(Session $session): SessionResource
    {
        return new SessionResource($session);
    }

    public function update(Session $session, UpdateSessionRequest $request): SessionResource
    {
        $session->update($request->validated());

        return new SessionResource($session);
    }
}
