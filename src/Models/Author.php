<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = array('id');

    public function books()
    {
        return $this->belongsToMany('Bishopm\Bookclub\Models\Book');
    }
}
