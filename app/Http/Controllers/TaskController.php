<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UnassignTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *      path="/tasks",
     *      operationId="getTasksList",
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Returns list of tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(): AnonymousResourceCollection
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    /**
     * @OA\Post(
     *     path="/tasks",
     *     operationId="storeTask",
     *     tags={"Tasks"},
     *     summary="Store new task",
     *     description="Returns task data",
     *    @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     *       ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=429, description="Too Many Requests")
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/tasks/{id}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task information",
     *      description="Returns task data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Task")
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
    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    /**
     * @OA\Put(
     *      path="/tasks/{id}",
     *      operationId="updateTask",
     *      tags={"Tasks"},
     *      summary="Update existing task",
     *      description="Returns updated task data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Task")
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
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/tasks/{id}",
     *      operationId="deleteTask",
     *      tags={"Tasks"},
     *      summary="Delete existing task",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
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
    public function destroy(Task $task): Response
    {
        $task->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/tasks/{task}/assign",
     *     operationId="assignTask",
     *     tags={"Tasks"},
     *     summary="Assign task to employee",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/AssignTaskRequest")
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     * )
     */
    public function assign(Task $task, AssignTaskRequest $request): TaskResource
    {
        $task->employees()->attach($request->validated());

        return TaskResource::make($task);
    }

    /**
     * @OA\Delete(
     *     path="/tasks/{task}/unassign",
     *     operationId="unassignTask",
     *     tags={"Tasks"},
     *     summary="Unassign task from employee",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/UnassignTaskRequest")
     *       ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */
    public function unassign(Task $task, UnassignTaskRequest $request): Response
    {
        $task->employees()->detach($request->validated());

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
