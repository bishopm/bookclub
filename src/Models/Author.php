<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = array('id');
    protected $appends = ['name'];

    public function books()
    {
        return $this->belongsToMany('Bishopm\Bookclub\Models\Book');
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->surname;
    }
}
