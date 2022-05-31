<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/admin/login",
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=406, description="not acceptable"),
     *   @OA\Response(response=500, description="internal server error"),
     *   @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *           @OA\Schema(
      *          type="string"
      *          )
     *      ),
     *   @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *           @OA\Schema(
      *          type="string"
      *              )
     *      )
     * )
     *
     */

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp', ['*'])->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }






    /**
     * @OA\Post(
     *   path="/api/admin/logout",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=204, description="successful operation"),
     *   @OA\Response(response=406, description="not acceptable"),
     *   @OA\Response(response=500, description="internal server error"),
     *
     * )
     *
     */

    public function logout()
    {
        Auth::guard()->logout();
        return response()->json([
            "message" => "Logout Successful"
        ]);
    }


}
