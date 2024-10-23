<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{

    public function enableTwoFactor(Request $request)
    {
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();


        $user = auth()->user();

        $user->two_factor_secret = encrypt($secret);
        $user->save();

        // Generate the QR code URL
        $QR_Image = $google2fa->getQRCodeInline(
            'YourAppName',
            $user->email,
            $secret
        );

        return view('2fa.2fa-setup', ['QR_Image' => $QR_Image, 'secret' => $secret]);
    }

    public function verifyTwoFactor(Request $request)
    {
        $google2fa = new Google2FA();
        $user = auth()->user();
        $secret = decrypt($user->two_factor_secret);

        // Validate the input
        $valid = $google2fa->verifyKey($secret, $request->input('2fa_code'));

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->intended('home');
        } else {
            return back()->withErrors(['2fa_code' => 'Invalid authentication code']);
        }
    }
}
