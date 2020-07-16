@extends('front.layouts.master')
@section('title','iletişim')
@section('bg','https://blackrockdigital.github.io/startbootstrap-clean-blog/img/contact-bg.jpg')
@section('contents')
    <div class="col-md-8 mx-auto">
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <p>Bizimle iletişime geçebilirsiniz </p>
        <form method="post" action="{{route('contact.post')}}">
            @csrf
            <div class="control-group">
                <div class="form-group  controls">
                    <label>Ad Soyad</label>
                    <input type="text" class="form-control" value="{{old('name')}}" placeholder="Ad Soyad" name="name" required >
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group  controls">
                    <label>Email Adresi</label>
                    <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Adres" name="email" required >
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 controls">
                    <label>Konu</label>
                    <select class="form-control" name="topic">
                        <option @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
                        <option @if(old('topic')=="Destek") selected @endif>Destek</option>
                        <option @if(old('topic')=="Genel") selected @endif>Genel</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group  controls">
                    <label>Mesajınız</label>
                    <textarea rows="5" name="message" class="form-control" placeholder="Mesaj" > {{old('message')}}</textarea>
                </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
            </div>
        </form>
    </div>
    <hr>
@endsection


