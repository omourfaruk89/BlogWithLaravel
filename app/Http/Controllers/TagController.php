<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use Session;

class TagController extends Controller
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
        //grab all the tags
        $tags = Tag::all();
        return view('tags.index')->withTags($tags);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validat the data
        $this->validate($request, array(
            'name' => 'required|max:255'
            ));

        //store in the database
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();

        Session::flash('success','New Tag has been successfully created!');

        return redirect()->route('tags.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        return view('tags.show')->withTag($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        return view('tags.edit')->withTag($tag);
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
        

        $this->validate($request, array(

            'name' => 'required|max:255'

            ));

        $tag = Tag::find($id);

        $tag->name = $request->name;
        $tag->save();

        Session::flash('success','New tag name has been successfully saved.');

        return redirect()->route('tags.show',$tag->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        //find the tag we want to delete according to its $id
        $tag = Tag::find($id);

        //detach all of the references associated with $tag
        $tag->posts()->detach();

        $tag->delete();

        Session::flash('success', 'Tag have been successfully deleted.');

        return redirect()->route('tags.index');
    }
}
