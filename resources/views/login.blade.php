@extends('layouts.app')
@section('content')
    <h1>Login</h1>
<form method="post" action="{{route('login')}}">
    @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{old('email')}}">
    @error('email')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
    @error('password')
      <span class="text-danger"> 
        <strong>{{ $message }}</strong> 
      </span>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection