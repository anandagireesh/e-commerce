<?php

use App\Services\ApiResponseService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $e) {
            $apiResponse = new ApiResponseService();
            return $apiResponse->error('Validation failed', 422, $e->errors());
        });
        $exceptions->renderable(function (AuthenticationException $e) {
            $apiResponse = new ApiResponseService();
            return $apiResponse->error('Unauthenticated', 401);
        });
        $exceptions->renderable(function (UnauthorizedException $e) {
            $apiResponse = new ApiResponseService();
            return $apiResponse->error('User does not have the right roles.', 403, ["unauthorized" => $e->getMessage()]);
        });
        $exceptions->renderable(function (ModelNotFoundException $e) {
            $apiResponse = new ApiResponseService();
            return $apiResponse->error('Model not found', 404, ["not_found" => $e->getMessage()]);
        });
        $exceptions->renderable(function (NotFoundHttpException $e) {
            $apiResponse = new ApiResponseService();
            return $apiResponse->error('Route not found', 404, ["not_found" => $e->getMessage()]);
        });
    })->create();
