@extends('layouts.app')
@section('content')

@guest
<a href="{{route('login')}}" class="btn btn-primary">Login</a>
@else
<a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
    @csrf
</form>
<a href="{{route('home')}}" class="btn btn-primary">Post New Blog</a>
@endif
<br>
<br>
    <div class="card">
      <div style="height: 200px;">
  <img class="card-img-top" src="{{asset('images/'.$blog->image)}}" style="max-width: 100%; max-height: 100%;">
</div>
  <div class="card-body">
    <h5 class="card-title pt-2"><b>{{$blog->title}}</b></h5>
    <p class="card-text">{!!$blog->description!!}</p>
  </div>
</div>


    <h1>Add your comment</h1>
<form method="post" action="{{route('comment',$blog->id)}}">
    @csrf
  <div class="form-group">
    <textarea class="form-control" placeholder="Comment" name="comment"></textarea>
    @error('comment')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<br>
@forelse($blog->parent_comments as $comment)
  @if($comment->blog)
    <ul style="list-style: none;">
      <li style="border-bottom: solid 1px #ccc; padding-bottom: 10px; padding-top: 10px;">
        <div>
          <img src="https://ui-avatars.com/api/?name={{$comment->user->name}}" style="border-radius: 50%; width: 50px;">
          {{$comment->user->name}} &nbsp;&nbsp; <small class="text-muted"><i class="fa fa-clock-o"></i> {{$comment->created_at->diffForHumans()}}</small>
        </div>
        <div>
          {{$comment->comment}}
        </div>
        <ul style="list-style: none;">
          <li>
            <h4><i class="fa fa-reply"></i> Reply to {{$comment->user->name}}</h4>
            <form method="post" action="{{route('comment',$blog->id)}}">
              <input type="hidden" name="comment_id" value="{{$comment->id}}">
              @csrf
              <div class="form-group">
                <textarea class="form-control" placeholder="Comment" name="comment"></textarea>
                @error('comment')
                  <span class="text-danger"> 
                    <strong>{{ $message }}</strong> 
                  </span>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            @forelse($comment->replies as $reply)
            <ul style="list-style: none;">
              <li style="border-bottom: solid 1px #ccc; padding-bottom: 10px; padding-top: 10px;">
                <div>
                  <img src="https://ui-avatars.com/api/?name={{$reply->user->name}}" style="border-radius: 50%; width: 50px;">
                  {{$reply->user->name}} &nbsp;&nbsp; <small class="text-muted"><i class="fa fa-clock-o"></i> {{$reply->created_at->diffForHumans()}}</small>
                </div>
                <div>
                  {{$reply->comment}}
                </div>
              </li>
            </ul>
            @empty
            @endif
          </li>
        </ul>
      </li>
  @endif
@empty
<h3 class="text-muted">Empty</h3>
@endforelse
@endsection