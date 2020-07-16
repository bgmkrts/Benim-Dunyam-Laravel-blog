@extends('front.layouts.master')
@section('title',$articles->title)
@section('bg',$articles->image)
@section('contents')
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-md-10 mx-auto">
                          {!!$articles->contents!!}
                            <span class="text-red">Okunma sayısı: <b>{{$articles->hit}} </b></span>
                        </div>
                        <div class="col-md-3">
                            <div class="card" >
                                <div class="card-header">
                                    Kategoriler
                                </div>
                                <div class="list-group">
                                    @foreach($categories as $category)
                                        <li class="list-group-item">
                                            <a href="{{route('category',$category->slug)}}" >{{$category->name}} </a>  <span class="badge bg-danger float-right text-white">{{$category->articleCount()}}</span>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
@endsection

