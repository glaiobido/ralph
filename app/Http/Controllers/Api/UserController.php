<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use App\User;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            //https://datatables.net/manual/server-side#Returned-data
            
            $user = User::skip($request->start)
                ->take($request->length)
                ->get();

            if ($request->has('search') && $request->search != "") {
                $user = User::where('firstname', 'LIKE', "%{$request->search}%")
                    ->orWhere('lastname', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%")
                    ->skip($request->start)
                    ->take($request->length)
                    ->get();
            }
           
            return new UserCollection($user, User::count(), $request->draw);

        } catch (\Throwable $th) {
            abort(500, $th->getMessage());
        }
    }
}
