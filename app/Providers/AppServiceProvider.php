<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // aseguramos que la aplicación utilice el idioma configurado
        // (normalmente 'es' a partir de config/app.php y el .env)
        app()->setLocale(config('app.locale'));
        // register our custom role-checking middleware so that we can
        // apply it easily inside route groups via `->middleware('role:...')`.
        // This approach is used instead of Kernel.php because the project
        // uses the new `bootstrap/app.php` style where the Http kernel class
        // is not present in the app directory.
        \Illuminate\Support\Facades\Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            function ($event) {
                \App\Models\Auditoria::create([
                    'id_usuario' => $event->user->id,
                    'id_caso' => null,
                    'sentencia' => 'LOGIN',
                    'estado_final' => json_encode([
                        'nota' => 'Inicio de sesión exitoso',
                        'ua' => request()->userAgent()
                    ]),
                    'ip' => request()->ip(),
                ]);
            }
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            function ($event) {
                if ($event->user) {
                    \App\Models\Auditoria::create([
                        'id_usuario' => $event->user->id,
                        'id_caso' => null,
                        'sentencia' => 'LOGOUT',
                        'estado_final' => json_encode([
                            'nota' => 'Cierre de sesión exitoso'
                        ]),
                        'ip' => request()->ip(),
                    ]);
                }
            }
        );
    }
}
