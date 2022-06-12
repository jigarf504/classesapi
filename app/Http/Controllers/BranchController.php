<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Exception;
use Illuminate\Http\{JsonResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $selectArr = [
                'id', 'branch_code', 'name', 'email',
                'mobile', 'contact_person_name',
                'contact_person_mobile',
                DB::raw('IF(is_active, "Active", "Inactive") AS status')
            ];

            $branches = Branch::select($selectArr)->cursorPaginate(5)->withQueryString();
            $data = [];
            if ($branches) {
                $data = [
                    'data' => $branches,
                    'message' => 'Branches details',
                    'status' => true
                ];
            } else {
                $data = [
                    'data' => null,
                    'message' => self::ERROR_MSG,
                    'status' => false
                ];
            }
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => self::ERROR_MSG, 'status' => false, 'data' => null], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), (new Branch)->rules);

            if ($validator->fails()) {
                return $this->getValidationErrorMessageAndResponse($this->modifyErrorMessage($validator->messages()->toArray()));
            }
            $branch = Branch::create($request->all());
            if ($branch) {
                return response()->json(["message" => 'Branch is created successfully.', 'status' => true, 'data' => $branch], 201);
            } else {
                return response()->json(["status" => false, 'message' => self::ERROR_MSG, 'data' => null], 500);
            }
        } catch (Exception $e) {
            return $this->getCatchErrorMessage($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function show(Branch $branch): JsonResponse
    {
        try {
            return response()->json(['data' => $branch, 'message' => 'Branch data', 'status' => true], 200);
        } catch (Exception $e) {
            return $this->getCatchErrorMessage($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(Request $request, Branch $branch): JsonResponse
    {
        try {
            $rulesArr = $branch->rules;
            if (isset($rulesArr['name'])) {
                $rulesArr['name'] = "required|unique:branches,name,$branch->id|max:125";
            }
            $validator = Validator::make($request->all(), $rulesArr);

            if ($validator->fails()) {
                return $this->getValidationErrorMessageAndResponse($validator->messages()->toArray());
            }

            if ($branch->update($request->all())) {
                return response()->json(['message' => 'Branch detail is updated successfully.!!', 'data' => $branch->refresh(), 'status' => true], 200);
            } else {
                return response()->json(['message' => self::ERROR_MSG, 'data' => null, 'status' => true], 500);
            }
        } catch (Exception $e) {
            return $this->getValidationErrorMessageAndResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Branch $branch): JsonResponse
    {
        try {
            if ($branch->delete()) {
                return response()->json(['message' => 'Branch is deleted successfully.!!', 'data' => null, 'status' => true], 200);
            } else {
                return response()->json(['message' => self::ERROR_MSG, 'data' => null, 'status' => true], 500);
            }
        } catch (Exception $e) {
            return $this->getValidationErrorMessageAndResponse($e);
        }
    }
}
