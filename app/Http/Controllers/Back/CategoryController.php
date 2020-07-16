<?php

namespace App\Http\Controllers\Back;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('back.categories.index',compact('categories'));
    }

    public function create(Request $request){


        $isExist=Category::whereSlug(str_slug($request->categories))->first();
        if($isExist){
            toastr()->error($request->categories.' adında bir kategori zaten mevcut!');
            return redirect()->back();
        }
        $categories = new Category;
        $categories->name=$request->category;
        $categories->slug=str_slug($request->category);
        $categories->save();
        toastr()->success('Kategori Başarıyla Oluşturuldu');
        return redirect()->back();
    }
    public function update(Request $request){
        $isSlug=Category::whereSlug(str_slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName=Category::whereName($request->categories)->whereNotIn('id',[$request->id])->first();
        if($isSlug or $isName){
            toastr()->error($request->categories.' adında bir kategori zaten mevcut!');
            return redirect()->back();
        }

        $categories = Category::find($request->id);
        $categories->name=$request->category;
        $categories->slug=str_slug($request->category);
        $categories->save();
        toastr()->success('Kategori Başarıyla Güncellendi');
        return redirect()->back();
    }
    public function delete(Request $request){
        $categories=Category::findOrFail($request->id);
        if($categories->id==1){
            toastr()->error('Bu kategori silinemez');
            return redirect()->back();
        }
        $message='';
        $count=$categories->articleCount();
        if($count>0){
            Article::where('category_id',$categories->id)->update(['category_id'=>1]);
            $defaultCategory=Category::find(1);
            $message='Bu kategoriye ait '.$count.' makale '.$defaultCategory->name. ' kategorisine taşındı.';
        }
        $categories->delete();
        toastr()->success($message,'Kategori Başarıyla Silindi');
        return redirect()->back();
    }

    public function getData(Request $request){
        $categories=Category::findOrFail($request->id);
        return response()->json($categories);
    }

    public function switch(Request $request){
        $categories=Category::findOrFail($request->id);
        $categories->status=$request->status=="true" ? 1 : 0 ;
        $categories->save();
    }
}
