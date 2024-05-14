<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AuthorRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\updateAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    $authors=Cache::remember('authors',15, function () {

        return Author::all();
        
    });

    return response()->json([
        'status' => 'success',
        'authors' => $authors
    ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {   
        DB::beginTransaction();
        try {
        $author=Author::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        'country' =>$request->country,
        ]);
        DB::commit();

        return response()->json([
            'status'=>'success',
            'author'=>$author
        ]);


    } catch (Throwable $e) {
        DB::rollBack();
        Log::error($e->getMessage());
        return response()->json([
            'status'=>'error',
            'message'=>$e->getMessage()
        ]);



    }}

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
       return $author= new AuthorResource($author);

        return response()->json([
            'status'=>'success',
            'author'=>$author,
          ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateAuthorRequest $request, Author $author)
    {
        try {
            $author = Author::find($author->id);

            $author->first_name = $request->first_name;
            $author->last_name = $request->last_name;
            $author->country = $request->country;


         
            
            $author= new AuthorResource($author);
            $author->save();
           
            return response()->json([
                'status'=>'success',
                'author'=>$author
            ]);
    
    
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);}}
        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
          
        return response()->json([
            'status'=>'delete 
            
            success',
            'author'=>$author
        ]);
    }
}
