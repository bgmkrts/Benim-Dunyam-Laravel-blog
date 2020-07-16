<?php

namespace App\Http\Controllers\Back;

use App\Models\Article;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    public function index(){
        $pages=Page::all();
        return view('back.pages.index',compact('pages'));
    }
    public function orders(Request $request){
        foreach($request->get('pages') as  $key => $order ){
            Page::where('id',$order)->update(['order'=>$key]);
        }
    }
    public function create(){
        return view('back.pages.create');
    }
    public function update($id){
        $pages=Page::findOrFail($id);
        return view('back.pages.update',compact('pages'));
    }
    public function updatePost(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title'=>'min:3',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pages= Page::findOrFail($id);
        $pages->title=$request->title;
        $pages->contents=$request->content;
        $pages->slug=str_slug($request->title);

        if($request->hasFile('image')){
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $pages->image='uploads/'.$imageName;
        }
        $pages->save();
        toastr()->success('Sayfa başarıyla güncellendi.');
        return redirect()->route('admin.page.index');
    }
    public function post(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $last=Page::orderBy('order','desc')->first();
        $pages= new Page;
        $pages->title=$request->title;
        $pages->contents=$request->content;
        return $request;
        $pages->order=$last->order+1;
        $pages->slug=str_slug($request->title);

        if($request->hasFile('image')){
            $imageName=str_slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $pages->image='uploads/'.$imageName;
        }
        $pages->save();
        toastr()->success('Sayfa başarıyla oluşturuldu');
        return redirect()->route('admin.page.index');
    }
    public function delete($id){

        $pages=Page::find($id);
        if(\Illuminate\Support\Facades\File::exists($pages->image)){
            File::delete(public_path($pages->image));
        }
        $pages->delete();
        toastr()->success('Sayfa başarıyla silindi');
        return redirect()->route('admin.page.index');
    }
    public function switch(Request $request){
        $page=Page::findOrFail($request->id);
        $page->status=$request->statu=="true" ? 1 : 0 ;
        $page->save();
    }
}
