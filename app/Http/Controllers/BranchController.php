<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'foobar' => 'fsdfs'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
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
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
