<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\Book;
use Bishopm\Bookclub\Models\User;
use Actuallymab\LaravelComment\Models\Comment;
use Bishopm\Bookclub\Repositories\AuthorsRepository;
use Bishopm\Bookclub\Repositories\BooksRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * @var BookRepository
     */
    private $book;
    private $author;

    public function __construct(BooksRepository $book, AuthorsRepository $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->book->all();
    }

    public function search(Request $request)
    {
        return $this->book->all($request->search);
    }

    public function genre($tag)
    {
        return Book::with('author')->whereTag($tag)->orderBy('title')->get();
    }

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id, $user_id=0)
    {
        $book = $this->book->find($id);
        $book->unrated = "1";
        $book->avg=$book->averageRate();
        foreach ($book->comments as $comment) {
            if (($comment->rate > 0) and ($comment->commented_id==$user_id)) {
                $book->unrated=0;
            }
        }
        return $book;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        if ($request->author_id < 0) {
            $author=$this->author->create(['author' => $request->newauthor]);
            $request->merge(['author_id' => $author->id]);
        }
        $book = $this->book->create($request->except('newauthor', 'genres'));
        $genres=array();
        foreach ($request->genres as $genre) {
            $genres[]=$genre->name;
        }
        $book->tag($genres);
        return $book;
    }

    public function addcomment(Request $request)
    {
        $book = Book::find($request->book_id);
        $user = User::find($request->user_id);
        $user->comment($book, $request->comment, $request->rating);
        return $request->newcomment;
    }

    public function deletecomment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
    }

    public function alltags()
    {
        return Book::allTags()->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Book $book
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        if ($request->author_id < 0) {
            $author=$this->author->create(['author' => $request->newauthor]);
            $request->merge(['author_id' => $author->id]);
        }
        $book = Book::find($id);
        $book->title=$request->title;
        $book->author_id=$request->author_id;
        $book->description=$request->description;
        $book->save();
        $book->untag();
        $genres=array();
        foreach ($request->genres as $genre) {
            $genres[] = $genre['name'];
        }
        $book->tag($genres);
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return Response
     */
    public function destroy(Book $book)
    {
        $this->book->destroy($book);
        return "deleted!";
    }
}
