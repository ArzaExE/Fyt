<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // protezione dai brute force, se sbagliato troppe volte applica un timer
        $this->ensureIsNotRateLimited();

        // Username o E-mail
        $login = $this->input('login');

        // Determina se è un'email o uno username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Aggiornamento dell'array' di credenziali
        $credentials = [
            $field => $login,
            'password' => $this->input('password'),
        ];

        // Auth::attempt tenta il login con le credenziali richieste
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            // 'Rate limiter' incrementa il numero di tentativi eseguiti
            RateLimiter::hit($this->throttleKey($field));

            // Messaggio di avviso per l'utente se le credenziali sono sbagliate troppe volte
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }
        // Azzeramento dei tentativi
        RateLimiter::clear($this->throttleKey($field));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Ottieni il login (che può essere email o username)
        $login = $this->input('login');

        // Determina se l'input è una email o uno username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Verifica se ci sono troppi tentativi di login per questo campo
        if (RateLimiter::tooManyAttempts($this->throttleKey($field), 5)) {
            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($this->throttleKey($field));

            throw ValidationException::withMessages([
                'login' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(string $field): string
    {
        return Str::transliterate(Str::lower($this->string($field)).'|'.$this->ip());
    }

}
