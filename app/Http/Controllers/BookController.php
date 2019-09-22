<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Book;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Books
        $books = Book::OrderBy('created_at', 'desc')->paginate(5);

        // Return collection of books as a resource
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = $request->isMethod('put') ? Book::findOrFail($request->book_id) : new Book;

        $book->id           = $request->input('book_id');
        $book->title        = $request->input('title');
        $book->description  = $request->input('description');
        $book->author       = $request->input('author');
        $book->field        = $request->input('field');

        if ($book->save()) {
            return new BookResource($book);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get single book
        $book = Book::findOrFail($id);

        // Return single book
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get book
        $book = Book::findOrFail($id);

        if ($book->delete()) {
            // Return deleted book
            return new BookResource($book);
        }
    }
}
