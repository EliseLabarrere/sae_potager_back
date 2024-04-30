<?php

namespace App\Http\Controllers;

use App\Models\CategGarden;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    /*************************
     * Authentification Sanctum
     *************************/


    /**
     * createUser()
     * Creating a user and their connection token
     * @param Request $request
     *      - name: string (required) - The name of the user.
     *      - email: string (required, unique) - The email address of the user.
     *      - password: string (required) - The password for the user. Must meet specified criteria.
     * @return token
     */
    public function createUser(Request $request)
    {
        // Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->uncompromised(),
            ],
        ], [
            'email.unique' => 'Email already exists',
            'password.min' => 'Password must be at least 8 characters long and contain mixed case letters and numbers',
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email already exists',
                ], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'categ_garden_id' => 1,
                'email_verified_at' => now(),
            ]);

            $token = $user->createToken("API TOKEN")->plainTextToken;

            $user->remember_token = $token;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $token,
            ], 200);
        } catch (\Throwable $th) {
            // En cas d'erreur, retourner un message d'erreur
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function updateUserGarden(Request $request)
    {
        //Validated
        $request->validate([
            'categ_garden' => 'required',
        ]);
        $user = Auth::user();

        $categGarden = CategGarden::where('slug', $request->categ_garden)->first();

        if ($categGarden) {
            $user->categ_garden_id = $categGarden->id;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User\'s garden has been updated',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Selected garden category does not exist',
            ], 404);
        }
    }

    /**
     * loginUser()
     * User login using email and password inputs
     * @param Request $request
     *        - email: string (required, unique) - The email address of the user.
     *        - password: string (required) - The password for the user. Must meet specified criteria
     * @return token
     */
    public function loginUser(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * logout()
     * Logging out the currently logged-in user
     * @return User
     */
    public function signOut()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Utilisateur déconnecté']);
    }



    /**
     * Return Info about the User
     * @return User name
     */
    public function user()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Delete The User
     */
    public function delete()
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens->each->delete();
            // Delete the user's account.
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé']);
        } else {
            return response()->json(['message' => 'Aucun utilisateur a supprimer'], 404);
        }
    }
}
