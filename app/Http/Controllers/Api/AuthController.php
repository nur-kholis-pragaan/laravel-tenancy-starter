<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponderHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendPasswordResetEmailJob;
use App\Jobs\SendPasswordResetSuccessfullJob;
use App\Models\SuperUser;
use App\Models\Tenant\TenantUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ResponderHelper;

    private $userModel;

    /**
     * Create class instance
     */
    public function __construct()
    {
        $this->userModel = new SuperUser();
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userModel->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->responseSuccess([
            'token' => $token,
        ], 200, 'Login successful');
    }

    /**
     * Displays the logged in user profile
     */
    public function user()
    {
        $user_id = auth()->id();

        $user = $this->userModel
            ->find($user_id);

        return $this->responseSuccess($user);
    }

    // /**
    //  * Logout user
    //  *
    //  * @param Request $request
    //  * @return void
    //  */
    // public function logout(Request $request)
    // {
    // 	$request->user()->tokens()->delete();

    // 	return response()->json([
    // 		'status' => 200,
    // 		'message' => 'Successfully logged out',
    // 		'payload' =>  $request->toArray(),
    // 	], 200);
    // }

    // /**
    //  * Forgot password 
    //  *
    //  * @param ForgotPasswordTest $request
    //  * @return void
    //  */
    // public function forgotPassword(ForgotPasswordRequest $request)
    // {
    // 	$user = $this->userModel->where('email', $request->email)->first();
    // 	$token = Password::createToken($user);

    // 	dispatch(new SendPasswordResetEmailJob($user, $token));

    // 	if ($token) {
    // 		return response()->json([
    // 			'status' => 200,
    // 			'message' => 'Password reset link sent to email.',
    // 			'payload' =>  $request->toArray(),
    // 		], 200);
    // 	} else {
    // 		throw new Exception('Unable to send reset link.');
    // 	}
    // }

    // /**
    //  * Reset password
    //  *
    //  * @param ResetPasswordRequest $request
    //  * @return void
    //  */
    // public function resetPassword(ResetPasswordRequest $request)
    // {
    // 	$status = Password::reset(
    // 		$request->only('email', 'password', 'password_confirmation', 'token'),
    // 		function ($user, $password) {
    // 			$user->forceFill([
    // 				'password' => Hash::make($password)
    // 			])->setRememberToken(Str::random(60));

    // 			$user->save();
    // 			dispatch(new SendPasswordResetSuccessfullJob($user));
    // 		}
    // 	);

    // 	if ($status == Password::PASSWORD_RESET) {
    // 		return response()->json([
    // 			'status' => 200,
    // 			'message' => 'Password has been successfully reset.',
    // 			'payload' =>  $request->only('email', 'token')
    // 		], 200);
    // 	} else {
    // 		throw new Exception('Unable to reset password.');
    // 	}
    // }
}
