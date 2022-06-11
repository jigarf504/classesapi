<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $selectArr = [
                'id', 'course_code', 'name', 'full_payment',
                'installment_payment',
                DB::raw('IF(is_active, "Active", "Inactive") AS status')
            ];
            return Course::select($selectArr)->cursorPaginate(5)->withQueryString();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Course $course) : JsonResponse
    {
        try {
            if ($course) {
                return response()->json(['data' => $course, 'status' => true], 200);
            } else {
                return response()->json(['data' => null, 'status' => false], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), (new Course)->rules);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if (Course::create($request->all())) {
                return response()->json(["message" => 'success', 'success' => true], 201);
            } else {
                return response()->json(["error" => true, 'message' => 'something_wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Course $course) : JsonResponse
    {
        try {
            $rulesArr = (new Course)->rules;
            if (isset($rulesArr['name'])) {
                $rulesArr['name'] = "required|unique:courses,name,$course->id|max:125";
            }

            $validator = Validator::make($request->all(), $rulesArr);
            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if ($course->update($request->all())) {
                return response()->json(["message" => 'success', 'success' => true], 201);
            } else {
                return response()->json(["error" => true, 'message' => 'something_wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destory(Course $course) : JsonResponse
    {
        try {
            if ($course->delete()) {
                return response()->json(['message' => 'success', 'status' => true], 200);
            } else {
                return response()->json(['message' => 'something_wrong', 'status' => true], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
