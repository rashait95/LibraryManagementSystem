<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\updateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * 


     */


    
    public function index()
    {
        
    $$books=Cache::remember('books', function () {

        return Book::with('authors')->get();
    });

    return response()->json([
        'status' => 'success',
        'books' => $books
    ], 200);

}

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        DB::beginTransaction();
        try {
        $book=Book::create([
            'title' => $request->title,
            'price' => $request->price,
        'published_at' =>$request->published_at,
        ]);
        DB::commit();

        return response()->json([
            'status'=>'success',
            'book'=>$book
        ]);


    } catch (Throwable $e) {
        DB::rollBack();
        Log::error($e->getMessage());
        return response()->json([
            'status'=>'error',
            'message'=>$e->getMessage()
        ]);

    }

}

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json([
            'status'=>'success',
            'book'=>$book,
          ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateBookRequest $request, Book $book)
    {
        try {
            $book= Book::find($book->id);

            $book->title= $request->title;
            $book->price= $request->price;
            $book->published_at= $request->published_at;
            

           

            $book->save();

           
            return response()->json([
                'status'=>'success',
                'book'=>$book
            ]);
    
    
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        $book->delete();
          
        return response()->json([
            'status'=>'delete 
            
            success',
            'book'=>$book
        ]);
    }
}
