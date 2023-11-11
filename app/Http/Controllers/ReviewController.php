<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // public function review(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|integer',
    //         'book_id' => 'required|integer',
    //         'review' => 'required|string',
    //     ]);
    //     $title = Book::where('id', $request->book_id)->pluck('title');
    //     // dd($title);
    //     if (!$validator->fails()) {
    //         try {
    //             Review::create([
    //                 'user_id' => $request->user_id,
    //                 'book_id' => $request->book_id,
    //                 'review' => $request->review,
    //                 'created_at' => now(),
    //             ]);
    //             return response()->json(['success' => "You have just reviewed $title[0]"], 200);
    //         } catch (Exception $e) {
    //             // return response()->json(['error' => "Bad Request!"], 400);
    //             return $e->getMessage();
    //         }
    //     } else {
    //         return response()->json(['error' => "Incorrect or Missing fields!"], 400);
    //     }
    // }
}
