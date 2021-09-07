<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function (User $user) {
            \Nova::whenServing(function (NovaRequest $request) use ($user) {
                $customerId = $request->viaRelationship() ? $request->viaResourceId : $request->user()->customer_id;

                $user->customer_id = $customerId;
            });
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_staff'          => 'boolean',
    ];

    public function isStaff(): bool
    {
        return $this->is_staff;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
