<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'review' => 'required|string',
        ]);
        // dd($title);
        if (!$validator->fails()) {
            try {
                Review::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'review' => $request->review,
                    'created_at' => now(),
                ]);
                return response()->json(['success' => "You have just reviewed"], 200);
            } catch (Exception $e) {
                // return response()->json(['error' => "Bad Request!"], 400);
                return $e->getMessage();
            }
        } else {
            return response()->json(['error' => "Incorrect or Missing fields!"], 400);
        }
    }

    public function rate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:users,id',
            'user_id' => 'required|integer|exists:books,id',
            'rating' => 'required|integer|between:1,5',
        ]);
        $title = Book::where('id', $request->book_id)->pluck('title');
        // dd($title);
        if (!$validator->fails()) {
            try {

                Rating::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'rating' => $request->rating,
                    'created_at' => now(),
                ]);
                return response()->json(['success' => "$title[0] is rated with $request->rating points out of 5."], 200);
            } catch (Exception $e) {
                return response()->json(['error' => "$title[0] cannot be rated again."], 400);
            }
        } else {
            return response()->json(['error' => "Incorrect or Missing fields!"], 400);
        }
    }

    public function rateAndReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:users,id',
            'user_id' => 'required|integer|exists:books,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string'
        ]);

        if (!$validator->fails()) {

            try {
                $ratedBook = Rating::where('book_id', $request->book_id)->where('user_id', $request->user_id)->first();
                if ($ratedBook) {
                    $this->review($request);
                    return response()->json(['You have reviewd a book but you cannot rate the same book again.'], 200);
                } else {
                    $this->rate($request);
                    $this->review($request);
                    return response()->json(['You have reviewed and rated a book.'], 200);
                }
            } catch (Exception $e) {
                return response()->json(['error' => 'Incorrect or Missing fields!'], 400);
            }
        } else {
            return response()->json(['error' => 'Incorrect or Missing fields!'], 400);
        }
    }
}
