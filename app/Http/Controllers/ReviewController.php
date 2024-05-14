<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('reviewable')->get();
        return response()->json([
            'status' => 'success',
            'reviews' => $reviews
        ], 200);
    
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_book_review(ReviewRequest $request,Book $book)
    {
        $review = $book->reviews()->create([
            'review' => $request->review,
        ]);
        return response()->json([
            'status'=>'success',
            'book_review'=>$review
        ]);

    }


    public function store_author_review(ReviewRequest $request,Author $author)
    {
        $review = $book->reviews()->create([
            'review' => $request->review,
        ]);

        return response()->json([
            'status'=>'success',
            ' review'=>$review
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json([
            'status'=>'success',
            'review'=>$review,
          ]);
    }

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review  $review)
    {
        $review->delete();

        return response()->json([
            'status'=>'deleted',
            'review'=>$review,
          ]);
    }
}
