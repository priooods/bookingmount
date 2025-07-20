<?php

namespace App\Http\Controllers;

use App\Models\TClimbersTab;
use Illuminate\Http\Request;

class PendakianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendakian = TClimbersTab::where('m_status_tabs', 4)->limit(60)->orderBy('id', 'desc')->get();
        return view('landingpage.pendakian', [
            'pendakian' => $pendakian
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
