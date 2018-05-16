<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;
use Bishopm\Bookclub\Models\Loan;
use Bishopm\Bookclub\Models\User;
use Bishopm\Bookclub\Models\Book;

class BooksRepository extends EloquentBaseRepository
{
    public function all($search='')
    {
        if ($search=='') {
            $books = $this->model->with('author', 'loans.user', 'comments')->orderBy('title')->get();
        } else {
            $books = Book::with('author', 'loans.user')->where('title', 'like', '%' . $search . '%')->orderBy('title')->get();
        }
        foreach ($books as $book) {
            $loan = Loan::with('user')->where('book_id', $book->id)->whereNull('returndate')->first();
            $book->status = $loan;
            $tot = 0;
            $rates = 0;
            foreach ($book->comments as $comment) {
                if ($comment->rate) {
                    $tot++;
                    $rates = $rates + $comment->rate;
                }
            }
            if ($tot) {
                $book->avg = round($rates / $tot);
            }
        }
        return $books;
    }

    public function find($id)
    {
        $book = $this->model->with('author', 'loans.user', 'comments', 'tags')->find($id);
        $loan = Loan::with('user')->where('book_id', $book->id)->whereNull('returndate')->first();
        $book->status = $loan;
        foreach ($book->comments as $comment) {
            $comment->user = User::find($comment->commented_id);
        }
        return $book;
    }

    public function avg($id)
    {
        $book = $this->model->with('comments')->find($id);
        $tot = 0;
        $rates = 0;
        foreach ($book->comments as $comment) {
            if ($comment->rate) {
                $tot++;
                $rates = $rates + $comment->rate;
            }
        }
        if ($tot) {
            return round($rates / $tot);
        } else {
            return null;
        }
    }

    public function toprated()
    {
        $books=$this->model->with('comments')->get();
        $fin=array();
        $dat=array();
        foreach ($books as $book) {
            $avg=$this->avg($book->id);
            if ($avg) {
                $fin[$avg][]=$book;
            }
        }
        krsort($fin);
        foreach ($fin as $key=>$avg) {
            foreach ($avg as $bk) {
                $bk->avg=$key;
                $dat[]=$bk;
            }
        }
        return $dat;
    }
}
