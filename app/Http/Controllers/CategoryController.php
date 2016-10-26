<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use Session;

class CategoryController extends Controller
{
    /*
    | if we would like to assign a condition that only authenticated users 
    |will be able to see the function of a particular controller class then
    |we need to simpley use the "middleware()" method from the controller 
    |constructor at the top of the controller class.
    | 
    |  public function __construct()
        {
            $this->middleware('auth');
        }

    | 
    |
    */

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
        //Display a list of all of our categories
        //it will also have a form to create a new category

        $categories = Category::all();

        return view('categories.index')->withCategories($categories);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Save a new categorey then redirect back to index
        $this->validate($request,[
            'name' => 'required|max:255'
            ]);

        $category = new Category;

        $category->name = $request->name;
        $category->save();
        // show the flash message on success
        Session::flash('success','Category has been sucessfully created!');

        //redirect to another page
        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
