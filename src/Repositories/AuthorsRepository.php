<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;
use Bishopm\Bookclub\Models\Loan;
use Bishopm\Bookclub\Models\User;
use Bishopm\Bookclub\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorsRepository extends EloquentBaseRepository
{
    public function all($search='')
    {
        if ($search=='') {
            $authors = Author::with(['books' => function ($query) {
                $query->where('owned', '=', 'owned');
            }])->orderBy('surname')->orderBy('firstname')->get();
        } else {
            $authors = Author::with('books')->where('surname', 'like', '%' . $search . '%')->orWhere('firstname', 'like', '%' . $search . '%')->orderBy('surname')->orderBy('firstname')->get();
        }
        return $authors;
    }

    public function find($id)
    {
        $author = $this->model->with(['books' => function ($query) {
            $query->where('owned', '=', 'owned');
        }])->find($id);
        foreach ($author->books as $book) {
            $loan = Loan::with('user')->where('book_id', $book->id)->whereNull('returndate')->first();
            $book->status = $loan;
            $book->avg = $book->averageRate();
        }
        return $author;
    }

    public function check($name)
    {
        $adata=array();
        $author = $this->model->whereRaw("CONCAT(firstname, ' ', surname) = ?", [$name])->first();
        if ($author) {
            $adata['existing']['value']= $author->id;
            $adata['existing']['name']= $author->surname . ", " . $author->firstname;
        } else {
            $names = explode(' ', $name);
            $firstname = array_shift($names);
            $surname = implode(' ', $names);
            $newauthor = Author::create(['firstname'=>$firstname, 'surname'=>$surname]);
            $adata['new']['value']= $newauthor->id;
            $adata['new']['name']= $newauthor->surname . ", " . $newauthor->firstname;
        }
        return $adata;
    }
}
