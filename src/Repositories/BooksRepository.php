<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;

class BooksRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->with('author', 'loans.user')->orderBy('title')->get();
    }

    public function find($id)
    {
        return $this->model->with('author')->find($id);
    }
}
