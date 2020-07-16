@extends('front.layouts.master')
@section('title','Benim Dünyam')
@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                    @foreach($articles as $article)
                        <div class="post-preview">
                            <a href="{{route('single',$article->slug)}}">
                                <h2 class="post-title">
                                    {{$article->title}}
                                </h2>
                                <img src="{{$article->image}}" width="250" height=”250″>
                                <h3 class="post-subtitle">
                                    {!!str_limit($article->contents,75)!!}
                                </h3>
                            </a>
                            <p class="post-meta">Kategori:
                                <a href="#">{{$article->getCategory->name}}</a>
                                <span class="float-right">{{$article->updated_at->diffForHumans()}}</span></p>
                        </div>

                            <hr>

                    @endforeach
                {{$articles->links()}}
{{--                <div class="clearfix">--}}
{{--                    <a class="btn btn-primary float-right " href="#">Older Posts &rarr;</a>--}}
{{--                </div>--}}
            </div>
            @isset($categories)
                <div class="col-md-3">
                        <div class="card">
                        <div class="card-header">
                            Kategoriler
                        </div>
                        <div class="list-group">
                            @foreach($categories as $category)
                                <li class="list-group-item">
                                    <a href="{{route('category',$category->slug)}}">{{$category->name}} </a> <span
                                        class="badge bg-danger float-right text-white">{{$category->articleCount()}}</span>
                                </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

