<?php

namespace App\Http\Controllers;

use App\Models\TNewsTab;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = TNewsTab::where('m_status_tabs', 2)->get();
        return view('landingpage.news', [
            'news' => $news
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
        $news = TNewsTab::where('id', $id)->first();
        return view('landingpage.newsdetail', [
            'news' => $news
        ]);
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
