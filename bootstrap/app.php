<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Tes cookies non chiffrés
        $middleware->encryptCookies(except: [
            'residence_to_reserve',
        ]);

        // 2. Déclare tes 3 middlewares pour pouvoir les utiliser dans web.php
        $middleware->alias([
            'is_pro'    => \App\Http\Middleware\ProMiddleware::class,
            'is_client' => \App\Http\Middleware\ClientMiddleware::class,
            'is_admin'  => \App\Http\Middleware\AdminMiddleware::class,
            'no-back'   => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // 3. APPLIQUE L'ANTI-RETOUR GLOBALEMENT
        // En l'ajoutant ici, toutes tes pages (Pro, Client, Admin)
        // seront protégées contre le bouton "Retour" du navigateur.
        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
