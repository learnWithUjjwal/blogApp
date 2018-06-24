<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use DB;  // to use SQL commands

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);//to disable the unauthorized person to edit or create post
    }

    public function index()
    {
        // $posts = Post::all();
        // $posts = Post::orderBy('created_at', 'desc') -> get();
        // $posts = Post::where('title', 'post Two')-> get();
        // $posts = DB::select('SELECT * FROM POSTS');
        // $posts = Post::orderBy('created_at', 'desc') -> take(1) -> get();
        $posts = Post::orderBy('created_at', 'desc') -> paginate(6);
        return view ('posts.index') -> with ('posts', $posts );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|mimes:jpeg,jpg,png,gif|nullable'
        ]);

        if($request->hasFile('cover_image')){
            //get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get only file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get only extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //get the complete file to be stored
            $fileNameToStore = $fileName."_".time().".".$extension;

            //upload file
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with ('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = Comment::where('post_id', $id)-> get();
        // $comments = Comment::all($id);
        // $data = [
        //     'post' => $post,
        //     'comments' => $comments            
        // ];
        
        return view ('posts.post')->with('post', $post)
                                ->with('comments', $comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id); 
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with ('error', "Unauthorized Access");    
        }

        
        return view('posts.edit')->with ('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $post = Post::find($id);
        if($request->hasFile('cover_image')){
            //get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get only file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get only extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //get the complete file to be stored
            $fileNameToStore = $fileName."_".time().".".$extension;
            //upload file
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
            //Delete Previous file
            unlink(public_path('storage/cover_image/'.$post->cover_image));
        }

       
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with ('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with ('error', "Unauthorized Access");    
        }
        if($post->cover_image !== "noimage.jpg"){
            unlink(public_path('/storage/cover_image/'.$post->cover_image));
        }
        
        $post->delete();
        
        return redirect('/posts')->with('success', 'POST DELETED');
    }
}
