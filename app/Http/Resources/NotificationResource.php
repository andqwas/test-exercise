<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="NotificationResource",
 *     description="Notification resource",
 *     @OA\Xml(
 *         name="NotificationResource"
 *     )
 * )
 */
class NotificationResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Notification[]
     */
    private array $data;
    public function toArray(Request $request): array
    {
        return [
          'employee_id' => $this->employee_id,
          'message' => $this->message,
          'read' => $this->read
        ];
    }
}
