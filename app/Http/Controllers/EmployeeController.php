<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     *      path="/employees",
     *      operationId="getEmployeesList",
     *      tags={"Employees"},
     *      summary="Get list of employees",
     *      description="Returns list of employees",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(): AnonymousResourceCollection
    {
        $employees = Employee::all();

        return EmployeeResource::collection($employees);
    }

    /**
     * @OA\Post(
     *     path="/employees",
     *     operationId="storeEmployee",
     *     tags={"Employees"},
     *     summary="Store new employee",
     *     description="Returns employee data",
     *    @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/StoreEmployeeRequest")
     *       ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/employees/{id}",
     *      operationId="getEmployeeById",
     *      tags={"Employees"},
     *      summary="Get employee information",
     *      description="Returns employee data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     @OA\Response(
     *           response=404,
     *           description="Resource Not Found"
     *       )
     * )
     */
    public function show(Employee $employee): EmployeeResource
    {
        return EmployeeResource::make($employee);
    }

    /**
     * @OA\Put(
     *      path="/employees/{id}",
     *      operationId="updateEmployee",
     *      tags={"Employees"},
     *      summary="Update existing employee",
     *      description="Returns updated employee data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateEmployeeRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Employee")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee->update($request->validated());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/employees/{id}",
     *      operationId="deleteEmployee",
     *      tags={"Employees"},
     *      summary="Delete existing employee",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Employee id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Employee $employee): Response
    {
        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
