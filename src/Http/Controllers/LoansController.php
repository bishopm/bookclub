<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\Loan;
use Bishopm\Bookclub\Repositories\LoansRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    /**
     * @var LoanRepository
     */
    private $loan;

    public function __construct(LoansRepository $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->loan->all();
    }

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->loan->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        return $this->loan->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Loan $loan
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $loan = Loan::find($request->id);
        $updatedloan = $this->loan->update($loan, ['returndate'=>$request->returndate]);
        return $updatedloan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Loan $loan
     * @return Response
     */
    public function destroy(Loan $loan)
    {
        $this->loan->destroy($loan);
        return "deleted!";
    }
}
