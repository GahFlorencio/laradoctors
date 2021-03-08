<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use \Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password','user_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * JWT Implements : https://medium.com/jwt-laravel-para-autentica%C3%A7%C3%A3o-de-servi%C3%A7os/jwt-laravel-para-autentica%C3%A7%C3%A3o-de-servi%C3%A7os-86d933f5c1a2
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'type'=> $this->user_type_id
        ];
    }

    /**
     * Laravel JWT Login Method
     * @param $array
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($array){
        if (!Auth::attempt(['email' => $array['email'], 'password' => $array['password']])) {
            return response()->json([],401);
        }
        $user = JWTAuth::fromUser(Auth::user());
        return response()->json($user);
    }

    /**
     * User Types
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_type(){
        return $this->belongsTo(UserType::class);
    }

    /**
     * Doctor Diponibilities
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disponibilities(){
        return $this->hasMany(Disponibility::class);
    }

    /**
     * Patient Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
