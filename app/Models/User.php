<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function userTweets()
  {
    return $this->hasMany(Tweet::class);
  }

  public function tweets()
  {
    return $this->belongsToMany(Tweet::class)->withTimestamps();
  }

  public function following()
  {
    return $this->hasManyThrough(User::class, Follow::class, 'user_id', 'id', 'id', 'following_id');
  }

  public function followers()
  {
    return $this->hasManyThrough(User::class, Follow::class, 'following_id', 'id', 'id', 'user_id');
  }
}
