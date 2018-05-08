<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\User');
    }
}
