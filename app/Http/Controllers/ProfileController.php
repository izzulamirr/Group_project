<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function main()
    {
        $profiles = Profile::all();
        return view ('transactions.index')->with('transaction',$profiles);
    }

    public function create1()
    {
        return view('transactions.create');
    }

/**
     * Display a listing of the resource.
     ** @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     
     */

    public function store1(Request $request)
    {
        $input = $request->all();
        Profile::create($input);
        return redirect('transaction')->with('flash_message','Transaction Added!');
    }


/**
     * Display a specific resources
     ** @param int $id
     * @return \Illuminate\Http\Response
     */

     public function show1($id)
     {
         $profiles = Profile::find($id);
         return view('transactions.view')->with('transactions', $profiles);
     }

     public function edit1($id)
     {
         $profiles = Profile::find($id);
         return view('transactions.edit')->with('transactions', $profiles);
     }

     /**
     * update a specific resources
     ** @param \Illuminate\Http\Request $request
     ** @param int $id
     *  @return \Illuminate\Http\Response
     */

     public function update1(Request $request, $id)
     {
        
        $profiles = Profile::findOrFail($id);
        $input = $request->all();

    $amount = $request->input('amount');
        
        $profiles->update($input);

        return redirect('transaction')->with('flash_message', 'Transaction Updated!');
     }

     public function destroy1($id)
     {
        Transaction::destroy($id);
        return redirect('transaction')->with('flash_message','Transaction Deleted!');    
     }
}