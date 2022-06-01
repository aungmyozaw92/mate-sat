<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof  BadRequestException) {
            return response(['status' => 4, 'message' => 'Invalid request to firestore'], Response::HTTP_OK);
        }
        if ($exception instanceof  RoleDoesNotExist) {
            return response(['status' => 2, 'message' => 'Role name does not exit'], Response::HTTP_OK);
        }
        if ($exception instanceof  UnauthorizedException) {
            return response(['status' => 2, 'message' => 'User does not have the right permissions.'], Response::HTTP_OK);
        }

        // if ($exception instanceof TokenBlacklistedException) {
        //     return response(['status' => 3, 'message' => 'Token can not be used, get new one'], Response::HTTP_OK);
        // }
        // if ($exception instanceof TokenInvalidException) {
        //     return response(['status' => 3, 'message' => 'Token is invalid'], Response::HTTP_OK);
        // }
        // if ($exception instanceof TokenExpiredException) {
        //     return response(['status' => 3, 'message' => 'Token is expired'], Response::HTTP_OK);
        // }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof AuthorizationException) {
            return response()->json(['status' => 2, 'message' => $exception->getMessage()], Response::HTTP_OK);
        }
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));

            if ($modelName == 'producttype') {
                $message = "Cannot find product type";
            } elseif ($modelName == 'producttag') {
                $message = "Cannot find product tag";
            } elseif ($modelName == 'variationmeta') {
                $message = "Cannot find variation meta";
            } elseif ($modelName == 'productvariation') {
                $message = "Cannot find product variation";
            } elseif ($modelName == 'productreview') {
                $message = "Cannot find product review";
            } elseif ($modelName == 'productdiscount') {
                $message = "Cannot find product discount";
            } else {
                $modelName = class_basename($exception->getModel());
                $message = "Cannot find {$modelName}";
            }
            return response()->json([
                'status' => 2,
                'message' => $message,
            ], Response::HTTP_OK);
        }
        if ($exception instanceof NotFoundHttpException) {
            if (str_contains(request()->url(), 'api')) {
                return response()->json(['status' => 2, 'message' => 'Incorect route'], Response::HTTP_OK);
            }
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['status' => 2, 'message' => 'The specified method for the request is invalid'], Response::HTTP_OK);
        }
        if ($exception instanceof PermissionDoesNotExist) {
            return response()->json(['status' => 2, 'message' => 'There is no [permission] with selected id for guard `api`.'], Response::HTTP_OK);
        }
        if ($exception instanceof InvalidArgumentException) {
            return response()->json(['status' => 2, 'message' => $exception->getMessage()], Response::HTTP_OK);
        }
     
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontend($request)) {
            return redirect()->guest('login');
        }
        return response()->json(['status' => 3, 'message' => 'Unauthenticated'], Response::HTTP_OK);
    }

    private function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())
            ->contains('web');
    }
}
