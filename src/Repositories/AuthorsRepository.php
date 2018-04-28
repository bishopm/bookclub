<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;

class AuthorsRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->with('books')->orderBy('author')->get();
    }

    public function find($id)
    {
        return $this->model->with('books')->find($id);
    }
}
