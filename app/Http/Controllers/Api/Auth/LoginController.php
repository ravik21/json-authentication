<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;

  /**
   * @SWG\Swagger(
   *   basePath="/api",
   *   @SWG\Info(
   *     title="Login request",
   *     version="1.0.0"
   *   )
   * )
   */

class LoginController extends Controller
{
  /**
   * @SWG\Post(
   *     path="/login",
   *     summary="Login with credentials.",
   *     tags={"Auth"},
   *     description="Permits an Authorization attempt.",
   *     operationId="authLogin",
   *      @SWG\Parameter(
   *       name="payload",
   *       in="formData",
   *       description="Payload must contian employee id and password.",
   *       required=true,
   *       type="string",
   *         @SWG\Schema(
   *              example={ "employee_id": 1234567, "password":123456}
   *         ),
   *   ),
   *     @SWG\Response(response="200",description="Successful operation."),
   *     @SWG\Response(response="422",description="Validation error."),
   *     @SWG\Response(response="401",description="Unauthorized User.")
   * )
   */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('employee_id', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
    * @SWG\Get(
    *     path="/logout",
    *     summary="Destroys a Access Token.",
    *     tags={"Auth"},
    *     description="Destroys the given Access Token.",
    *     operationId="authLogout",
    *     produces={"application/json"},
    *     @SWG\Parameter(
    *         name="Authorization",
    *         in="header",
    *         description="Valid User Token for logged in User.",
    *         required=true,
    *         type="string",
    *         @SWG\Items(type="string"),
    *     ),
    *     @SWG\Response(response="200",description="Successfully logged out."),
    *     @SWG\Response(response="401",description="Unauthorized User."),
    * )
    */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => 'Bearer '.$token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
