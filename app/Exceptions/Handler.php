<?php

namespace App\Exceptions;

use App\Exceptions\Custom\InvalidCodeException;
use App\Exceptions\Custom\WrongPasswordException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
//        dd($e);
        $locale = $request->header('Accept-Language');
        if ($locale) {
            app()->setLocale($locale);
        }
        $error_files = explode('\\', $e->getFile());
        $error_file = end($error_files);
        if ($e instanceof NotFoundHttpException && $error_file === 'AbstractRouteCollection.php') {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => trans('handler.route_not_found'),
            ], 404);
        }
        if (($e instanceof ModelNotFoundException && $request->wantsJson()) || $e instanceof NotFoundHttpException && $error_file === 'Application.php') {
            return response()->json(['status' => 'fail', 'message' => trans('handler.no_data_found'), 'data' => null], 404);
        }

        if ($e instanceof AuthenticationException && $request->wantsJson()) {
            return response()->json(['status' => 'fail', 'message' => trans('handler.login_first'), 'data' => null], 401);
        }
        if ($e instanceof FileDoesNotExist) {
            return failResponse(404, trans('handler.file.not_found'));
        }
        if ($e instanceof FileIsTooBig) {
            return failResponse(413, trans('handler.file.too_big'));
        }
        if ($e instanceof WrongPasswordException) {
            return failResponse($e->getCode(), $e->getMessage());
        }
        if ($e instanceof InvalidCodeException) {
            return failResponse($e->getCode(), $e->getMessage());
        }
        return parent::render($request, $e);
    }
}
