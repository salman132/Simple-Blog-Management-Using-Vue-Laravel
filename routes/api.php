<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles',function (){
    $articles = \App\Articales::orderBy('created_at','DESC')->paginate(10);

    return response()->json($articles);
});

Route::get('article/{id}',function ($id){
   $article = \App\Articales::findOrFail($id);

   return response()->json($article);
});

Route::post('article',function (Request $request){

    $article = new \App\Articales();

    $article->title = $request->title;
    $article->description = $request->description;
    $article->save();

    return response()->json($request->all());
});

Route::put('article',function (Request $request){

    $article = \App\Articales::find($request->article_id);

    $article->title = $request->title;
    $article->description = $request->description;
    $article->save();

    return response()->json($request->all());
});

Route::delete('article/{id}',function ($id){
    $article = \App\Articales::destroy($id);
    return response()->json('Deleted successfully');
});
