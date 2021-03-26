@extends('layouts.app')
@section('content')
    @guest
    

<h1>Please <a href="{{route('login.form')}}">login</a> to post a blog</h1>

@else
<a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
    @csrf
</form>
<h1>Post a blog</h1>
<form method="post" action="{{route('create')}}" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label>*Title</label>
    <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}">
    @error('title')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <div class="form-group">
    <label>Image</label>
    <input type="file" class="form-control" placeholder="Image" name="image" accept="image/*">
    @error('image')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <div class="form-group">
    <label>*Description</label>
    <textarea class="form-control" placeholder="Description" name="description">{!!old('description')!!}</textarea>
    @error('description')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endguest

<hr>

<div class="row">
@forelse($blogs as $blog)
  <div class="col-sm-4">
    <div class="card" style="margin-bottom: 15px;">
      <div style="height: 150px;">
  <img class="card-img-top" src="{{asset('images/'.$blog->image)}}" style="max-width: 100%; max-height: 149px;">
</div>
  <div class="card-body">
    <h5 class="card-title pt-2"><b>{{$blog->title}}</b></h5>
    <p class="card-text">{!!mb_strimwidth($blog->description, 0, 100, '...')!!}</p>
    <p class=""><a class="btn btn-primary" href="{{route('blog.desc',$blog->slug)}}">Read More...</a></p>
    <div>
          <img src="https://ui-avatars.com/api/?name={{$blog->user->name}}" style="border-radius: 50%; width: 50px;">
          {{$blog->user->name}} &nbsp;&nbsp; <small class="text-muted"><i class="fa fa-clock-o"></i> {{$blog->created_at->diffForHumans()}}</small>
        &nbsp;&nbsp; <i class="fa fa-commenting-o"></i> {{$blog->comments->count() }} &nbsp;&nbsp; 
        
        <a style="text-decoration: none;" href="#" onclick="event.preventDefault(); document.getElementById('like-form-{{$blog->id}}').submit();">
          @guest
          <i class="fa fa-thumbs-o-up" title="Like"></i> 
          @else
            @if(Auth::user()->like()->where('blog_id',$blog->id)->exists())
            <i class="fa fa-thumbs-up" title="Dislike"></i> 
            @else
            <i class="fa fa-thumbs-o-up" title="Like"></i> 
            @endif
          @endif
        </a>
          {{$blog->likes->count()}}</a>
        <form id="like-form-{{$blog->id}}" action="{{route('like',$blog->id)}}" method="POST" style="display: none;">
            @csrf
        </form>
        </div>
  </div>
</div>
  </div>
@empty
<h1 class="text-muted text-center">Empty</h1>
@endforelse
</div>
@endsection