<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BusinessConfiguration;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class RecaptchaMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     * @throws ConnectionException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $config = BusinessConfiguration::where('key', 'google_recaptcha')->first();

        if ($config?->is_active) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            if (!$recaptchaResponse) {
                return response()->json(['message' => 'The reCAPTCHA response is required.'], 422);
            }

            $recaptchaConfig = json_decode($config->test_values, true);
            $gResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaConfig['secret_key'],
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);

            if (!$gResponse->json('success')) {
                return response()->json(['message' => 'The reCAPTCHA is invalid.'], 422);
            }
        }

        return $next($request);
    }
}

