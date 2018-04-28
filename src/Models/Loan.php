<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\User');
    }

    public function book()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\Book');
    }
}
