<?php

namespace App\Observers\Central;

use App\Models\Business;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class BusinessObserver
{
    public function saved(Business $business)
    {
        if (request()->file()) {
            foreach (array_keys(request()->file()) as $file_collection) {
                switch ($file_collection) {
                    case 'logo':
                        try {
                            if ($business->getFirstMedia('logo')) {
                                $business->getFirstMedia('logo')->delete();
                            }
                            $file_extension = request()->file('logo')->getClientOriginalExtension();
//                            generate random name for the file
                            $name = Str::random(10) . '_' . now()->timestamp . '.' . $file_extension;
                            $business->addMedia(request()->file('logo'))
                                ->setFileName($name)
                                ->setName($name)
                                ->toMediaCollection('logo');
                        } catch (FileDoesNotExist|FileIsTooBig $e) {
                        }
                        break;
                }
            }
        }
    }


}
