<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Membership;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $data=membership::paginate(12);
        return view('pages.memberships.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.memberships.create-member');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        Membership::create([
            'name_membership'=>$request->name_membership,
           'limit_transaction'=>$request->limit_transaction,

        ]);
        return redirect('membership')->with('info', 'Data Berhasil Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $mber=membership::findorfail($id);
        return view('pages.memberships.edit-member', compact('mber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mber=membership::findorfail($id);
        $mber->update($request->all());

        return redirect('membership')->with('info', 'Update Berhasil Tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $mber=membership::findorfail($id);
         $mber->delete();
         return back()->with('info', 'Data Berhasil Dihapus');
    }
}
