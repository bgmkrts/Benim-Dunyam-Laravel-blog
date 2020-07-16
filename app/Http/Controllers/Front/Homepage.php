<?php

namespace App\Http\Controllers\Front;

use App\Models\Article;
use App\Models\Config;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;

class Homepage extends Controller
{

    public function __construct(){
        if(Config::find(1)->active==0){
            return redirect()->to('site-bakimda')->send();
        }
        view()->share('config',Config::find(1));
    }

    public function index()
    {
        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(4);
        $data['articles']->withPath(url('sayfa'));
        $data['categories'] = Category::inRandomOrder()->get();
        $data['pages'] = Page::orderBy('order', 'ASC')->get();
        return view('front.homepage', $data);
    }

    public function single($slug, Request $request)
    {

        $articles = Article::whereSlug($request->slug)->first() ?? abort(403, 'Böyle Bir Yazı Bulunamadı');
        $categories = Category:: find($articles->category_id) ?? abort(403, 'Böyle Bir Kategori Bulunamadı');
        $articles->increment('hit');
        $data['articles'] = $articles;
        $data['categories'] = Category::inRandomOrder()->get();
        $data['pages'] = Page::orderBy('order', 'ASC')->get();

        return view('front.single', $data);
    }

    public function category($slug)
    {
        // return $slug;//
        $categories = Category:: where("slug", $slug)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı');
        $data['categories'] = $categories;
        $data['articles'] = Article::where('category_id', $categories->id)->orderBy('created_at', 'DESC')->get();
        $data['pages'] = Page::orderBy('order', 'ASC')->get();
        return view('front.category', $data);
    }

    public function page($slug)
    {
        $pages = Page::where('slug',$slug)->first() ?? abort(403, 'Böyle bir sayfa bulunamadı.');
        $data['page'] = $pages;
        $data['pages'] = Page::orderBy('order', 'ASC')->get();

        return view('front.page', $data);
    }
    public function contact(){
        $data['pages'] = Page::orderBy('order', 'ASC')->get();
        return view('front.contact',$data);
    }
    public function contactpost(Request $request){
        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10'
        ];

       $validate= Validator::make($request->post(),$rules);
       if($validate->fails()){
        return redirect()->route('contact')->withErrors($validate)->withInput();
       }
        Mail::send([],[], function($message) use($request){
            $message->from('iletisim@benimdunyam.com','Blog Sitesi');
            $message->to('begumkaratas18@gmail.com');
            $message->setBody(' Mesajı Gönderen :'.$request->name.'<br />
                    Mesajı Gönderen Mail :'.$request->email.'<br />
                    Mesaj Konusu : '.$request->topic.'<br />
                    Mesaj :'.$request->message.'<br /><br />
                    Mesaj Gönderilme Tarihi : '.now().'','text/html');
            $message->subject($request->name. ' iletişimden mesaj gönderdi!');
        });

         $contact = new Contact;
         $contact->name=$request->name;
         $contact->email=$request->email;
         $contact->topic=$request->topic;
         $contact->message=$request->message;
         $contact->save();
        return redirect()->route('contact')->with('success','Mesajınız bize iletildi. Teşekkür ederiz!');
    }
}

