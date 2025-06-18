<?php

namespace App\Http\Controllers;

use App\Http\Filters\TaskFilter;
use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\FilterTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UnassignTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tasks",
     *     operationId="getTasksList",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     description="Returns list of tasks",
     *     @OA\Parameter(
     *         name="title",
     *         description="Task title",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         description="Task description",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Task status",
     *         @OA\Schema(
     *             type="string",
     *             enum={"В работе", "К выполнению", "Выполнена"},
     *             example="В работе"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="created_at_from",
     *         in="query",
     *         description="Дата начала (YYYY-MM-DD)",
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2025-06-20"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="created_at_to",
     *         in="query",
     *         description="Дата окончания (YYYY-MM-DD)",
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2025-06-21"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Sort tasks by",
     *         @OA\Schema(
     *             type="string",
     *             enum={"title", "description", "status", "created_at"},
     *             example="title"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order sort",
     *         @OA\Schema(
     *             type="string",
     *             enum={"asc", "desc"},
     *             example="asc"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */
    public function index(FilterTaskRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        $filter = app()->make(TaskFilter::class, ['queryParams' => $data]);
        $tasks = Task::filter($filter)->get();

        if ($tasks->isEmpty()) {
            abort(404, 'Задачи не найдены');
        }

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
     *     @OA\Response(response=429, description="Too Many Requests")
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(ResponseAlias::HTTP_CREATED);
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
     *       )
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
        $data = $request->validated();

        if ($task->hasEmployee($data['employee_id'])) {
            abort(422, 'У сотрудника уже есть эта задача');
        }

        $task->employees()->attach($data);

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
     *     )
     * )
     */
    public function unassign(Task $task, UnassignTaskRequest $request): Response
    {
        $task->employees()->detach($request->validated());

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/tasks/grouped-by-status",
     *     operationId="getTasksGroupedByStatus",
     *     tags={"Tasks"},
     *     summary="Get tasks grouped by status",
     *     description="Returns all tasks grouped by status",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={
     *                     "Выполнена": {
     *                         {"id": 1, "title": "Task 1", "description" : "Task description", "status": "Выполнена"},
     *                         {"id": 2, "title": "Task 2", "description" : "Task 2 description", "status": "Выполнена"}
     *                     },
     *                     "В работе": {
     *                         {"id": 3, "title": "Task 3", "description" : "Task 3 description", "status": "В работе"}
     *                     }
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function groupedByStatus(): JsonResponse
    {
        $tasks = Task::all()
            ->groupBy('status')
            ->map(function ($tasks) {
                return TaskResource::collection($tasks);
            });


        return response()->json(['data' => $tasks]);
    }
}
