<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author = Author::with('book')->get();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Success get all author",
            'data' => $author
        ]);
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
        $author = Author::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Success create author",
            'data' => $author
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $author = Author::with('book')->find($author->id);
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Success get author with id = ".$author->id,
            'data' => $author
        ]);
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
    public function update(Request $request, Author $author)
    {
        $author->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Success update author with id = ".$author->id,
            'data' => $author
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Success delete author with id = ".$author->id,
            'data' => ""
        ]);
    }
}
