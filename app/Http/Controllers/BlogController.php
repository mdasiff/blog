<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'blog']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::get();
        return view('blog', ['blogs'=>$blogs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            //'email'   => 'required|email:exists',
            'title'   => 'required|max:198',
            'description'   => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rule);


        $image = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/'), $image);

        Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
            'image' => $image,
        ]);

        return back()->with('success', 'Blog Posted');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
    public function blog(Blog $blog)
    {
        return view('blog-view',['blog'=>$blog]);
    }
    public function like(Blog $blog)
    {
        $isliked = Like::where('blog_id',$blog->id)->where('user_id',Auth::id())->first();

        if($isliked){
            $isliked->delete();
            return back();
        }
        
        Like::create([
            'user_id' => Auth::id(),
            'blog_id' => $blog->id
        ]);
        return back();
    }
}
