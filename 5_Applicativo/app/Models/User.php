<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function role()
    {
        return $this->belongsTo(user_roles::class, 'role_id'); // Assicurati che 'role_id' sia il nome della colonna FK
    }

    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'address',
        'city',
        'postcode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Funzione per generare uno username nel formato nome.cognome
    public static function generateUsername($name, $surname)
    {
        $baseUsername = Str::lower($name) . '.' . Str::lower($surname); // Esempio: "giovanni.rossi"

        $username = $baseUsername;
        $counter = 1;

        // Verifica se lo username esiste già nel database
        while (self::where('username', $username)->exists()) {
            $username = $baseUsername . $counter; // Aggiunge un numero incrementale
            $counter++;
        }

        return $username;
    }

    public function getFormattedBornDateAttribute()
    {
        return Carbon::parse($this->born_date)->format('d-m-Y');
    }
}
