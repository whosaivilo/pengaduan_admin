<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table      = 'users'; // Nama tabel di database
    protected $primaryKey = 'id';    // Nama Primary Key

    //Kolom yang dapat diisi
    protected $fillable = [
        'profile_picture',
        'name',
        'email',
        'password',
        'role',

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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
    public function scopeSearch($query, $request, array $columns)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
            });
        }
    }
    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }

        return $query;
    }
    public function getProfilePictureUrlAttribute()
    {
        // Jika user upload foto → pakai itu
        if ($this->profile_picture) {
            // Kalau URL eksternal
            if (filter_var($this->profile_picture, FILTER_VALIDATE_URL)) {
                return $this->profile_picture;
            }

            // Kalau file lokal
            return asset('storage/' . $this->profile_picture);
        }

        // DEFAULT placeholder
        return asset('assets/img/user.jpeg');
    }

}
