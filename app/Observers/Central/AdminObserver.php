<?php

namespace App\Observers\Central;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class AdminObserver
{
    /**
     * Handle the User "saved" event.
     */

    public function saved(User $user)
    {
        if (request()->file()) {
            foreach (array_keys(request()->file()) as $file_collection) {
                switch ($file_collection) {
                    case 'avatar':
                        try {
                            if ($user->getFirstMedia('avatar')) {
                                $user->getFirstMedia('avatar')->delete();
                            }
                            $file_extension = request()->file('avatar')->getClientOriginalExtension();
                            $name = Str::random(10) . '_' . now()->timestamp . '.' . $file_extension;
                            $user->addMedia(request()->file('avatar'))
                                ->setFileName($name)
                                ->setName($name)
                                ->toMediaCollection('avatar');
                        } catch (FileDoesNotExist|FileIsTooBig $e) {
                        }
                        break;
//                    case 'logo':
//                        break;
                }

            }
        }
    }
}
