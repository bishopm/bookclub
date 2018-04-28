<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;

class UsersRepository extends EloquentBaseRepository
{
    public function find($id)
    {
        return $this->model->with('loans.book')->find($id);
    }
}
