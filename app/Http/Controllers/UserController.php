<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => 'Incorrect or Missing fields!'], 400);
            } else {
                $data = $request->all();
                $data['password'] = Hash::make($request->input('password'));
                User::create($data);
                return response()->json(['error' => 'Successfully create user'], 201);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create user'], 400);
        }
    }
}
