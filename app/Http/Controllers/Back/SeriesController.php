<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Reference;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = Series::all();
        $references = Reference::all()->sortBy('title')->sortBy('type');

        return view('back.series.index', compact('series', 'references'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $references = Reference::all()->sortBy('title')->sortBy('type');

        return view('back.series.create', compact('references'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $series = Series::create($request->all());
        $series->references()->attach($request->references);

        return redirect()->route('back.series.index')->with('message', '新規シリーズを登録しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $series = Series::findOrFail($id);
        $articles = $series->blogs()->get()->sortBy('series_pos');

        return view('back.series.show', compact('articles', 'series'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $series = Series::findOrFail($id);

        $references = Reference::all()->sortBy('title')->sortBy('type');
        $checkedReferences = $series->references()->pluck('title', 'reference_id');

        return view('back.series.edit', compact('series', 'references', 'checkedReferences'));
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
        $series = Series::findOrFail($id);
        $series->references()->sync($request->references);
        $series->title = $request->title;
        $series->save();

        return redirect()->route('back.series.index')->with('message', 'シリーズ情報を更新しました！');
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
