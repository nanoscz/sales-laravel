<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option;

        if ($search == '') {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->orderBy('article.id','desc')->paginate(10);
        } else {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->where('article.'.$option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total' => $articles->total(),
                'current_page' => $articles->currentPage(),
                'per_page' => $articles->perPage(),
                'last_page' => $articles->lastPage(),
                'from' => $articles->firstItem(),
                'to' => $articles->lastItem()
            ],
            'articles' => $articles
        ];
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listArticleSales(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option;

        if ($search == '') {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->where('article.stock','>','0')
            ->orderBy('article.id','desc')->paginate(10);
        } else {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->where('article.stock','>','0')
            ->where('article.'.$option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return ['articles' => $articles];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modalarticles(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option;

        if ($search == '') {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->orderBy('article.id','desc')->paginate(10);
        } else {
            $articles = Article::join('category','article.id_category','=','category.id')
            ->select('article.id','article.code','article.name','article.price','article.stock','article.description','article.state','article.id_category','category.name as category')
            ->where('article.'.$option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return ['articles' => $articles];
    }


    /**
     * Display a categories of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function articles(Request $request)
    {   
        $filter = $request->filter;
        if (!$request->ajax()) return redirect('/'); 
        $articles = Article::where('code','=', $filter)
        ->select('id','name')->orderBy('name','asc')->get();

        return ['articles' => $articles];
    }

    /**
     * Display a categories of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function searchArticles(Request $request)
    {   
        $filter = $request->filter;
        if (!$request->ajax()) return redirect('/'); 
        $articles = Article::where('code','=', $filter)
        ->select('id','name','stock','price')
        ->where('stock','>','0')
        ->orderBy('name','asc')->get();

        return ['articles' => $articles];
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $article = new Article();
        $article->id_category = $request->id_category;
        $article->code = $request->code;
        $article->name = $request->name;
        $article->price = $request->price;
        $article->stock = $request->stock;
        $article->description = $request->description;
        $article->state = '1';
        $article->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $article = Article::findOrFail($request->id);
        $article->id_category = $request->id_category;
        $article->code = $request->code;
        $article->name = $request->name;
        $article->price = $request->price;
        $article->stock = $request->stock;
        $article->description = $request->description;
        $article->state = 1;
        $article->save();
    }

    /**
     * changeState the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeState(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $article = Article::findOrFail($request->id);
        if ($article->state == '1') {
            $article->state = '0';
        } else {
            $article->state = '1';
        }
        $article->save();
    }
}
