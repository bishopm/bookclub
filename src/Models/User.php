<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Bishopm\Bookclub\Models\Setting;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use CanComment;
    use SoftDeletes;
    use HasRoles;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function books()
    {
        return $this->hasMany('Bishopm\Bookclub\Models\Book');
    }

    public function loans()
    {
        return $this->hasMany('Bishopm\Bookclub\Models\Loan');
    }
}
