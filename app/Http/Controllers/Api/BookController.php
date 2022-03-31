<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;

use App\Models\Book;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::with('author')->get();
        
        return $this->sendResponse($book, "success get all book");
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
        if ($file = $request->file('image')) {
            $uploadFolder = 'books';

            $image_uploaded_path = $file->store($uploadFolder);

            $book = Book::create([
                'author_id' => $request->author_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => Storage::disk('public')->url($image_uploaded_path)
            ]);

            if (!$book) {
                return $this->sendError("", "failed create book");
            }
            
        } else {
            $book = Book::create([
                'author_id' => $request->author_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => 'default.jpg'
            ]);

            if (!$book) {
                return $this->sendError("", "failed create book");
            }
        }

        return $this->sendResponse($book, "success create book");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $book = Book::where('id', $id)->with('author')->first();

        if (!$book) {
            return $this->sendError("", "book with id = ".$id." not found");
        }

        return $this->sendResponse($book, "Success get book with id = ".$book->id);
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
        $book = Book::find($id);
        if (!$book) {
            return $this->sendError("", "book with id = ".$id." not found");
        }
        $book->update([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return $this->sendResponse($book, "Success update book with id = ".$book->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $book = Book::find($id);
        if (!$book) {
            return $this->sendError("", "book with id = ".$id." not found");
        }
        $book->delete();

        return $this->sendResponse("", "Success delete book with id = ".$book->id);
    }
}
