<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index($id = null, $name = null)
    {
        if ($id) {
            try {
                return Book::findOrFail($id);
            } catch (Exception $e) {
                return response()->json(['error' => 'Bad Request!'], 400);
            }
        } else {
            return Book::all();
        }
    }
    public function getDetails($id)
    {
        $msg = '';
        try {
            $book = Book::findOrFail($id);
            $msg .= $book;

            $rating = intval(Rating::where('book_id', $id)->sum('rating'));
            $total_rate = Rating::where('book_id', $id)->count() * 5;
            // $rating = Rating::avg('rating');
            if ($total_rate > 0) {
                $avg_rating = round($rating / $total_rate * 100);
                $msg .= ',{"average_rating": ' . json_encode($avg_rating) . '%}';
            } else {
                $avg_rating = 0;
                $msg .=  ',{"average_rating": ' . json_encode($avg_rating) . '%}';
            }

            $review = Review::where('book_id', $id)->get();

            $msg .= ', "reviews": ' . $review;
            return $msg;
        } catch (Exception $e) {
            return response()->json(['error' => 'Bad Request!'], 400);
        }
    }
    public function store(Request $request)
    {
        try {
            Book::create($request->all());
            return response()->json(['message' => 'Book created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create book'], 400);
        }
    }
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|',
            'author' => 'required|string|',
            'genre' => 'required|string|',
            'description' => 'required|string|',
        ]);
        if (!$validator->fails()) {
            try {
                $book = Book::findOrfail($id);
                $book->update($request->all());
                return response()->json(['message' => 'Book updated successfully'], 201);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to update book'], 400);
            }
        } else {
            return response()->json(['error' => 'Incorrect or Missing fields!'], 400);
        }
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:books,id'
        ]);
        if (!$validator->fails()) {
            try {
                Book::destroy($id);
                return response()->json(['message' => 'Book Deleted!'], 201);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete book'], 400);
            }
        } else {
            return response()->json(['error' => 'Incorrect or Missing fields!'], 400);
        }
    }
}
