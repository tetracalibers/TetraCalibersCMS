<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Series;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        $articles = $tag->find($id)->blogs()->get();
        $series = Series::all()->pluck('title', 'id')->toArray();
        $articlesBySeries = [];

        foreach ($series as $series_id => $series_title) {
            $articlesBySeries[] = $articles->sortBy('series_pos')->where('series_id', $series_id)->toArray();
        }

        $articlesNotBelongSeries = $articles->sortByDesc('created_at')->where('series_id', null);
        $articlesNotBelongSeries = $articlesNotBelongSeries->merge($articles->sortByDesc('created_at')->where('series_id', 0))->toArray();

        return view('front.tag.show', compact('tag', 'articles', 'series', 'articlesBySeries', 'articlesNotBelongSeries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
