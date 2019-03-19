<?php

namespace GottaShit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    const LOCALE = [
        'es' => 'es_ES.UTF-8',
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->setLanguage($request->route('language'));

        return $next($request);
    }

    private function setLanguage(?string $language = null): void
    {
        $language = $this->getLanguage($language);

        $this->setLocale($language);
    }

    private function getLanguage(?string $language): string
    {
        if (Auth::check()) {
            return Auth::user()->language;
        }

        if (Session::get('language')) {
            return Session::get('language');
        }

        if (is_null($language)) {
            return $this->getLanguageFromBrowser();
        }

        return $language;
    }

    private function getLanguageFromBrowser(): string
    {
        $accept = strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]);

        $lang = explode(",", $accept);

        $primary_language = explode('-', $lang[0]);

        $language = $primary_language[0];

        if (!in_array($language, ['en', 'es'])) {
            $language = 'en';
        }

        return $language;
    }

    private function setLocale(string $language): void
    {
        App::setLocale($language);

        setlocale(LC_TIME, self::LOCALE[$language] ?? '');
    }
}
