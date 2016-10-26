<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;
use App\Tag;
use Session;
use Purifier;
use Image;
use Storage;

class PostController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //create a variable and store all the blog posts in it from the database
        $posts = Post::orderBy('id','desc')->paginate(5);
        // return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        //validate the data
        $this->validate($request, array(
                'title'          => 'required|max:255',
                'slug'           => 'required|alpha_dash|min:5|max:255',
                'category_id'    => 'required|integer',
                'body'           => 'required',
                'featured_image' => 'sometimes|image'
            ));

        //store in the database
        $post = new Post;

        $post->title       = $request->title;
        $post->slug        = $request->slug;
        $post->category_id = $request->category_id;
        $post->body        = Purifier::clean($request->body);

        //save our image
        if ($request->hasFile('featured_image')){           

            $image    = $request->file('featured_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->resize(800,400)->save($location);

            $post->image = $filename;
        }

        $post->save();
        $post->tags()->sync($request->tags,false);

        //session(['success'=> 'The blog post was sucessfully saved!']);

        Session::flash('success','The blog post was sucessfully saved!');

        //redirect to another page
        return redirect()->route('posts.show',$post->id);

        
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

        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the post in the database and save as a variable 
        $post       = Post::find($id);
        $categories = Category::all();
        $tags       = Tag::all();
        // return the view and pass in the var we previously created
        return view('posts.edit')->withPost($post)->withCategories($categories)->withTags($tags);
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
        //validate the data
        $post = Post::find($id);

        

            $this->validate($request, array(
                'title'       => 'required|max:255',
                'slug'        => "required|min:5|max:255|unique:posts,slug,$id",
                'category_id' => 'required|integer', 
                'body'        => 'required'
            ));
        
         
        //save the data to the database
         

         $post->title       = $request->input('title');
         $post->slug        = $request->input('slug');
         $post->category_id = $request->input('category_id');
         $post->body        = Purifier::clean($request->input('body'));

         if ($request->hasFile('featured_image')){            
            //uplodad the new photo
            $image    = $request->file('featured_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->resize(800,400)->save($location);
            $old_file_name = $post->image;

            //save it into database
            $post->image = $filename;

            //Delete the old photo
            Storage::delete($old_file_name);
         }
         $post->save();  

         if(isset($request->tags))
         {
            //when there must be at least one tag value 
            $post->tags()->sync($request->tags,true);
         }
         else
         {
            $post->tags()->sync(array());
         }
         

         //set flash data with sucess message
         Session::flash('success','This post has been successfully updated.');

        //redirect with flash data to posts.show
         return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        //find the post to be deleted by their id  and store it in a variable
        $post = Post::find($id);

        //delete all references related to post
        $post->tags()->detach();

        //delete the photo
        Storage::delete($post->image);

        //delete the post to be deleted
        $post->delete();



        //set a flash data with success message
        Session::flash('success','The blog post was successfully deleted .');

        //rederict with flash data to posts.index
        return redirect()->route('posts.index');
    }
}
