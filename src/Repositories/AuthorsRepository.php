<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;
use Bishopm\Bookclub\Models\Loan;
use Bishopm\Bookclub\Models\User;
use Bishopm\Bookclub\Models\Author;

class AuthorsRepository extends EloquentBaseRepository
{
    public function all($search='')
    {
        if ($search=='') {
            $author = $this->model->with('books')->orderBy('surname', 'firstname')->get();
        } else {
            $author = Author::with('books')->where('author', 'like', '%' . $search . '%')->orderBy('surname', 'firstname')->get();
        }
        return $author;
    }

    public function find($id)
    {
        $author = $this->model->with('books')->find($id);
        foreach ($author->books as $book) {
            $loan = Loan::with('user')->where('book_id', $book->id)->whereNull('returndate')->first();
            $book->status = $loan;
            $book->avg = $book->averageRate();
        }
        return $author;
    }
}
