<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Jobs\MyJob;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Services\NewsService;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $News = News::where('active', true)
        ->orderBy('created_at', 'desc')->paginate(3);

        return view('index' ,compact('News'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        $request->validated();
        $news = NewsService::store($request);
        return redirect()->route('index');
      
       // return redirect()->route('news.show', ['news' => $news]);

    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {   
       return view('show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $request->validated();

        $originalNews  = NewsService::update($request,$news); 
        return redirect()->route('index');
       // return redirect()->route('news.show', ['news' => $originalNews]);
    }

    public function showDestroy(News $news)
    {
        return view('destroy', compact('news'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
       NewsService::deleteTag($news);
       $news->delete();

       return redirect()->route('news.destroyInfo');
    }

    public function destroyInfo()
    {
        return view('destroyInfo');
    }


}
