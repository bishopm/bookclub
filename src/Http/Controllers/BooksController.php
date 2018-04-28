<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\Book;
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

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->book->find($id);
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
        return $this->book->create($request->except('newauthor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Book $book
     * @param  Request $request
     * @return Response
     */
    public function update(Book $book, Request $request)
    {
        $book = $this->book->update($book, $request->all());
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
