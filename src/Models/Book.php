<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Actuallymab\LaravelComment\Commentable;

class Book extends Model implements TaggableInterface
{
    use TaggableTrait, Commentable;

    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

    public function author()
    {
        return $this->belongsToMany('Bishopm\Bookclub\Models\Author');
    }

    public function loans()
    {
        return $this->hasMany('Bishopm\Bookclub\Models\Loan');
    }
}
