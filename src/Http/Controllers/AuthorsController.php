<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\Author;
use Bishopm\Bookclub\Repositories\AuthorsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * @var AuthorRepository
     */
    private $author;

    public function __construct(AuthorsRepository $author)
    {
        $this->author = $author;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->author->all();
    }

    public function search(Request $request)
    {
        return $this->author->all($request->search);
    }

    public function check(Request $request)
    {
        return $this->author->check($request->author);
    }

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->author->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        return $this->author->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Author $author
     * @param  Request $request
     * @return Response
     */
    public function update(Author $author, Request $request)
    {
        $author = $this->author->update($author, $request->all());
        return $author;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Author $author
     * @return Response
     */
    public function destroy(Author $author)
    {
        $this->author->destroy($author);
        return "deleted!";
    }
}
