<?php

namespace App\Http\Controllers\Back;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $articles=Article::orderBy('created_at','desc')->get();
        $categories=Category::orderBy('created_at','desc')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $articles=new Article;
        $articles->title=$request->title;
        $articles->category_id=$request->category;
        $articles->contents=$request->contents;
        $articles->slug=str_slug($request->title);

        if($request->hasFile('image')){
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $articles->image='uploads/'.$imageName;
        }
        $articles->save();
        toastr()->success('Başarılı', 'Makale başarıyla oluşturuldu');
        return redirect()->route('admin.makaleler.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articles=Article::findOrFail($id);
        $categories=Category::all();
        return view('back.articles.update',compact('categories','articles'));
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
       // return $request ;
        $validator = Validator::make($request->all(), [
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $articles= Article::findOrFail($id);
        $articles->title=$request->title;
        $articles->category_id=$request->category;
        $articles->contents=$request->content;
        $articles->slug=str_slug($request->title);

        if($request->hasFile('image')){
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $articles->image='uploads/'.$imageName;
        }
        $articles->save();
        toastr()->success('Başarılı', 'Makale başarıyla güncellendi.');
        return redirect()->route('admin.makaleler.index');

    }
    public function switch(Request $request){
$articles=Article::findOrFail($request->id);
        $articles->status=$request->statu=="true" ? 1 : 0 ;
        $articles->save();
    }
    public function delete($id){
        Article::find($id)->delete();
        toastr()->success('Makale, Silinen makalelere taşındı.');
        return redirect()->route('admin.makaleler.index');
    }
    public function trashed(){
        $articles= Article::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('back.articles.trashed',compact('articles'));
    }
    public function recover($id){
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale kurtarıldı');
        return redirect()->back();
    }
    public function hardDelete($id){
        $articles=Article::onlyTrashed()->find($id);
        if(File::exists($articles->image)){
            File::delete(public_path($articles->image));
        }
        $articles->forceDelete();
        toastr()->success('Makale başarıyla silindi');
        return redirect()->route('admin.makaleler.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
