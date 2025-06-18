<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNotificationRequest;
use App\Http\Requests\MarkReadNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NotificationController extends Controller
{
    /**
     * @OA\Post(
     *      path="/notifications",
     *      operationId="getNotificationsList",
     *      tags={"Notifications"},
     *      summary="Get list of notifications",
     *      description="Returns list of notifications",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/GetNotificationRequest")
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/NotificationResource")
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     *  )
     */
    public function index(GetNotificationRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        $notifications = Notification::where('employee_id', $data['employee_id'])
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($notifications->isEmpty()) {
            abort(404, 'Notifications not found');
        }

        return NotificationResource::collection($notifications);
    }

    /**
     * @OA\Put(
     *      path="/notifications/{id}/read",
     *      operationId="markAsReadNotification",
     *      tags={"Notifications"},
     *      summary="Update existing notification",
     *      description="Returns updated motification data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Notification id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Notification")
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
    public function markAsRead(Notification $notification): JsonResponse
    {
        $notification->update(['read' => true]);

        return (new NotificationResource($notification))
            ->response()
            ->setStatusCode(ResponseAlias::HTTP_ACCEPTED);
    }
}
