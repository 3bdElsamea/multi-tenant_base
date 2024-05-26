<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class CustomException extends Exception
{
    protected string $locale;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->locale = request()->header('Accept-Language');
        if ($this->locale) {
            app()->setLocale($this->locale);
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(): JsonResponse
    {
        return failResponse($this->getCode(), $this->getMessage());
    }
}
