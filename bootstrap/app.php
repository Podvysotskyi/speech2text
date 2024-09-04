<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/status',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->expectsJson();
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return Inertia::render('Error', [
                'status' => Response::HTTP_NOT_FOUND,
                'request_method' => $request->method(),
            ])->toResponse($request)->setStatusCode(Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            $data = [
                'status' => Response::HTTP_METHOD_NOT_ALLOWED,
                'request_method' => $request->method(),
            ];
            if (App::hasDebugModeEnabled()) {
                $data['debug_message'] = $e->getMessage();
            }

            return Inertia::render('Error', $data)
                ->toResponse($request)->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        });
    })->create();
