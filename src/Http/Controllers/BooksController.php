<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\Book;
use Bishopm\Bookclub\Models\User;
use Actuallymab\LaravelComment\Models\Comment;
use Cartalyst\Tags\IlluminateTag;
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
    private $authors;

    public function __construct(BooksRepository $book, AuthorsRepository $authors)
    {
        $this->middleware('auth:api');
        $this->book = $book;
        $this->authors = $authors;
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

    public function wishlist()
    {
        return $this->book->wishlist();
    }

    public function search(Request $request)
    {
        return $this->book->all($request->search);
    }

    public function genre($tag)
    {
        return Book::with('authors')->whereTag($tag)->orderBy('title')->get();
    }

    public function comments()
    {
        return Comment::with('commented', 'commentable')->orderBy('created_at', 'DESC')->get();
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
        $book->avg=$this->book->avg($id);
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
        $existing = Book::where('isbn', $request->isbn)->first();
        if (!$existing) {
            $book = $this->book->create($request->except('authors', 'genres'));
            $genres=array();
            foreach ($request->genres as $genre) {
                $genres[]=$genre['name'];
            }
            $book->tag($genres);
            foreach ($request->authors as $author) {
                if ($author['value']<1) {
                    $newauthor=$this->authors->check($author['name']);
                    $book->authors()->attach($newauthor['new']['value']);
                } else {
                    $book->authors()->attach($author['value']);
                }
            }
            return $book;
        }
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
        $tags = IlluminateTag::orderBy('slug')->get();
        foreach ($tags as $tag) {
            if ($tag->count == 0) {
                $del = IlluminateTag::find($tag->id)->delete();
            }
        }
        return IlluminateTag::orderBy('slug')->get();
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
        $book = Book::find($id);
        $book->title=$request->title;
        $book->image=$request->image;
        $book->isbn=$request->isbn;
        $book->description=$request->description;
        $book->owned=$request->owned;
        $book->save();
        $book->untag();
        $genres=array();
        foreach ($request->genres as $genre) {
            $genres[] = $genre['name'];
        }
        $book->tag($genres);
        $adat=array();
        foreach ($request->authors as $author) {
            $adat[]=$author['value'];
        }
        $book->authors()->sync($adat);
        return $book;
    }

    public function delete($id, Request $request)
    {
        $book = Book::find($id);
        $book->untag();
        foreach ($book->comments as $comment) {
            $comment->delete();
        }
        foreach ($book->loans as $loan) {
            $loan->delete();
        }
        $book->delete();
        return "deleted";
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
