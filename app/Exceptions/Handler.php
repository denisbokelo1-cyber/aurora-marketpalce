<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * The list of exception types that should not be reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ValidationException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ThrottleRequestsException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log only - never display technical details to users
        });
    }

    public function render($request, Throwable $exception)
    {
        // Authentication exceptions - redirect to login
        if ($exception instanceof AuthenticationException) {
            if (!$request->expectsJson()) {
                $uri = $request->getRequestUri();
                if (Str::contains($uri, '/admin') || Str::contains($uri, '/seller/') || Str::contains($uri, '/delivery_boy/')) {
                    return redirect()->route('admin.login');
                }
                return redirect()->route('login');
            }
            return response()->json(['message' => 'Veuillez vous connecter pour continuer.'], 401);
        }

        // Authorization exceptions
        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès refusé. Vous ne disposez pas des autorisations nécessaires.'], 403);
            }
            return response()->view('errors.403', [], 403);
        }

        // Model not found
        if ($exception instanceof ModelNotFoundException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Ressource introuvable.'], 404);
            }
            return response()->view('errors.404', [], 404);
        }

        // Token mismatch (419)
        if ($exception instanceof TokenMismatchException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Votre session a expiré. Veuillez actualiser la page.'], 419);
            }
            return redirect()->back()->withInput()->with('message', 'Votre session a expiré. Veuillez réessayer.');
        }

        // Too many requests (429)
        if ($exception instanceof ThrottleRequestsException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Trop de tentatives. Veuillez patienter quelques instants avant de réessayer.'], 429);
            }
            return response()->view('errors.429', [], 429);
        }

        // Not found (404)
        if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Page introuvable.'], 404);
            }
            return response()->view('errors.404', [], 404);
        }

        // HTTP exceptions (403, 419, 500 etc.)
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            
            $viewName = match($statusCode) {
                403 => 'errors.403',
                404 => 'errors.404',
                419 => 'errors.419',
                429 => 'errors.429',
                500, 502, 503, 504 => 'errors.500',
                default => 'errors.500',
            };
            
            if (view()->exists($viewName)) {
                return response()->view($viewName, ['exception' => $exception], $statusCode);
            }
            
            return response()->view('errors.500', [], 500);
        }

        // Validation exceptions
        if ($exception instanceof ValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Certaines informations sont invalides. Merci de corriger les champs indiqués.',
                    'errors' => $exception->errors(),
                ], 422);
            }
            return redirect()->back()
                ->withInput($request->except($this->dontFlash))
                ->withErrors($exception->errors(), $exception->errorBag)
                ->with('error', 'Certaines informations sont invalides. Merci de corriger les champs indiqués.');
        }

        // In production: catch all remaining exceptions and show friendly 500 page
        if (!config('app.debug')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Une erreur interne est survenue. Notre équipe a été informée automatiquement.'
                ], 500);
            }
            
            // Log the exception for debugging
            $this->report($exception);
            
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $exception);
    }
}
