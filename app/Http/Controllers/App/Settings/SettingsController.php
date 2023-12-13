<?php

namespace App\Http\Controllers\App\Settings;

use App\Models\UserGhost;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function changeEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        try {
            $user = $request->user();
            $newEmail = User::where('email', $request->email)->first();
            if (isset($newEmail)) {
                throw new Exception("email already exists", 405);
            }
            $user->update([
                'email' => $request->email,
                'email_verified_at' => null,
            ]);
            $user->sendEmailVerificationNotification();
            auth('api')->logout();
            return finalResponse('success', 200, 'Logout successfully please check your mail to verify email and login again');
        } catch (Exception $e) {
            return finalResponse('faild', 500, null, null, $e->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',                    // Minimum length
                'regex:/^(?=.*[A-Z])/',     // At least one uppercase letter
                'regex:/^(?=.*[a-z])/',     // At least one lowercase letter
                'regex:/^(?=.*[0-9])/',     // At least one digit
                'regex:/^(?=.*[@$!%*?&])/'], // At least one special character
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = $request->user();

        // Check if the current password matches the user's actual password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return finalResponse('failed', 401, null, null, 'Current password is incorrect');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return finalResponse('success', 200, 'Password changed successfully');
    }


    public function changeToGhost(Request $request)
    {
        $request->validate([
            'ghost_mode' => 'required|boolean',
        ]);
        try{
            $user = $request->user();
            $mood = $request->ghost_mode;
            $ghost = UserGhost::firstOrCreate(['user_id' => $user->id], [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'photo' => $user->photo,
            ]);

            $user->update([
                'ghost_mood' => $mood,
                'photo' => env('APP_URL') . "/public/storage/Ghost/ghost.jpg",
                'first_name' => $mood ? 'Spectra' : $ghost->first_name,
                'last_name' => $mood ? 'Shadowvale' : $ghost->last_name,
                'phone' => $mood ? null : $ghost->phone,
            ]);
            return finalResponse('success', 200, 'Ghost mode updated successfully');
        }catch(Exception $e){
            return finalResponse('failed', 500, null, null, 'internal server error');
        }
    }
}

