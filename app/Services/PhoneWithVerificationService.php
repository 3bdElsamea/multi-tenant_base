<?php

namespace App\Services;

use App\Exceptions\Custom\InvalidCodeException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PhoneWithVerificationService
{
    /////**//////////////////////////////////////////////////////////////////////////////////////////////|
    /* The only functionality Implemented here is to send the verification code to the phone number      |
    /* and update the user phone with the verification code                                              |
    /* if ur logic has more than this, then you can add it here                                          |
    *////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Send Verification Code
     */
    private function sendCode($user, $verify_column): object
    {
        $phone = ['phone_code' => $user->phone_code, 'phone' => $user->phone];
        /**
         * You should implement the methodToSentVerificationCode
         * to send the verification code sms to the phone number
         */
//      $verification_code = methodToSentVerificationCode($phone);
        $verification_code = '1111';  // this is just a dummy code should be replaced with the real code
        $user->update([$verify_column => $verification_code]);
        return $user;
    }

    /**
     * Update Phone With Verification Code
     * @throws Exception
     */
    public function updatePhoneWithVerificationCode($user, string $code, array $new_phone): object
    {
        if ($user->verified_code != $code) {
            throw new InvalidCodeException(trans('api.profile.invalid_code'), 422);
        }
        $user->update([
            'phone' => $new_phone['phone'],
            'phone_code' => $new_phone['phone_code'],
            'verified_code' => null,
//            'is_active' => 1, // depends on your business logic
//            'phone_verified_at' => now() // if you want to save the phone verification time
        ]);
        return $user;
    }

    /**
     * Edit Wrong Phone
     * if Entered wrong while registration
     */
    public function editPhone(Model $model, array $old_phone, array $new_phone): object
    {
        $user = $model::where('phone_code', $old_phone['phone_code'])
            ->where('phone', $old_phone['phone'])
            ->first();
        $user->update([
            'phone_code' => $new_phone['phone_code'],
            'phone' => $new_phone['phone']
        ]);
        $this->sendCode($user, 'verified_code');
        return $user;
    }
}
