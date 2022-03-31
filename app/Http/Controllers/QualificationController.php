<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class QualificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $selectArr = [
                'id', 'name',
                DB::raw('IF(is_active, "Active", "Inactive") AS status')
            ];
            return Qualification::select($selectArr)->cursorPaginate($request->limit ?? 5)->withQueryString();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Qualification $qualification)
    {
        try {
            if ($qualification) {
                return response()->json(['data' => $qualification, 'status' => true], 200);
            } else {
                return response()->json(['data' => null, 'status' => false], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => "required|unique:qualifications,name|max:125"
            ]);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if (Qualification::create($request->all())) {
                return response()->json(["message" => 'success', 'success' => true], 201);
            } else {
                return response()->json(["error" => true, 'message' => 'something_wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Qualification $qualification)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => "required|unique:qualifications,name,$qualification->id|max:125"
            ]);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if ($qualification->update($request->all())) {
                return response()->json(["message" => 'success', 'success' => true], 201);
            } else {
                return response()->json(["error" => true, 'message' => 'something_wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destory(Qualification $qualification)
    {
        try {
            if ($qualification->delete()) {
                return response()->json(['message' => 'success', 'status' => true], 200);
            } else {
                return response()->json(['message' => 'something_wrong', 'status' => true], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
