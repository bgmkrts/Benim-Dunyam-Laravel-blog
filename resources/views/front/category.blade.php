@extends('front.layouts.master')
@section('title',$categories->name.' Kategorisi')
@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                @if(count($articles)>0)
                @foreach($articles as $article)

                    <div class="post-preview">
                        <a href="{{route('single',[$article->getCategory->slug,"slug"=>$article->slug])}}">
                            <h2 class="post-title">
                                {{$article->title}}
                            </h2>
                            <img src="{{$article->image}}"  width="250" height=”250″>
                            <h3 class="post-subtitle">
                                {!!str_limit($article->contents,75)!!}
                            </h3>
                        </a>
                        <p class="post-meta">Kategori:
                            <a href="#">{{$article->getCategory->name}}</a>
                            <span class="float-right">{{$article->updated_at->diffForHumans()}}</span> </p>
                    </div>
                @endforeach
                @else
                    <div class="alert alert-danger">
                        <h1>Bu kategoriye ait yazı bulunamadı</h1>
                    </div>
                @endif

            </div>
            <div class="col-md-3">
                <div class="card" >
                    <div class="card-header">
                        Kategoriler
                    </div>
                    <div class="list-group">
{{--                        @foreach($categories as $category)--}}
                            <li class="list-group-item">
                                <a href="{{route('category',$categories->slug)}}">{{$categories->name}} </a>
                                <span class="badge bg-danger float-right text-white">{{$categories->articleCount()}}</span>
                            </li>
{{--                        @endforeach--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

