<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $selectArr = [
                'id', 'branch_code', 'name', 'email',
                'mobile', 'contact_person_name',
                'contact_person_mobile',
                DB::raw('IF(is_active, "Active", "Inactive") AS status')
            ];
            return Branch::select($selectArr)->cursorPaginate(5)->withQueryString();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), (new Branch)->rules);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if (Branch::create($request->all())) {
                return response()->json(["message" => 'success', 'success' => true], 201);
            } else {
                return response()->json(["error" => true, 'message' => 'something_wrong'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function show(Branch $branch) : JsonResponse
    {
        try {
            if ($branch) {
                return response()->json(['data' => $branch, 'status' => true], 200);
            } else {
                return response()->json(['data' => null, 'status' => false], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(Request $request, Branch $branch) : JsonResponse
    {
        try {
            $rulesArr = $branch->rules;
            if (isset($rulesArr['name'])) {
                $rulesArr['name'] = "required|unique:branches,name,$branch->id|max:125";
            }
            $validator = Validator::make($request->all(), $rulesArr);

            if ($validator->fails()) {
                return response()->json(["message" => $validator->messages()], 201);
            }

            if ($branch->update($request->all())) {
                return response()->json(['message' => 'success', 'status' => true], 200);
            } else {
                return response()->json(['message' => 'something_wrong', 'status' => true], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Branch $branch) : JsonResponse
    {
        try {
            if ($branch->delete()) {
                return response()->json(['message' => 'success', 'status' => true], 200);
            } else {
                return response()->json(['message' => 'something_wrong', 'status' => true], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
