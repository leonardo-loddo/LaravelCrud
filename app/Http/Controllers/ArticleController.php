<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{
    public function index(){
        $articles = Article::all();
        return view('article.index', compact('articles'));
    }
    public function show(Article $article){
        return view('article.show', compact('article'));
    }
    public function create(){
        return view('article.create');
    }
    public function store(ArticleStoreRequest $request){
        //$extension_name = $request->file('image')->getClientOriginalExtension();

        $path_image = '';
        if ($request->hasFile('image')){
            $file_name = $request->file('image')->getClientOriginalName();
            $path_image = $request->file('image')->storeAs('public/image', $file_name);
        }
        Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path_image,
        ]);

        return redirect()->route('article.index')->with('success', 'Libro Caricato');
    }
    public function edit(Article $article){
        return view('article.edit', compact('article'));
    }
    public function update(ArticleUpdateRequest $request, Article $article){
        $path_image = $article->image;//inserisce l'immagine precedente

        if ($request->hasFile('image')){
            $file_name = $request->file('image')->getClientOriginalName();
            $path_image = $request->file('image')->storeAs('public/image', $file_name);
        }
        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path_image,
        ]);

        return redirect()->route('article.index')->with('success', 'Libro Aggiornato');
    }
    public function destroy(Article $article){
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Libro Eliminato');
    }
}
