<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="EmployeeResource",
 *     description="Employee resource",
 *     @OA\Xml(
 *         name="EmployeeResource"
 *     )
 * )
 */
class EmployeeResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Employee[]
     */
    private array $data;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'roles' => RoleResource::collection($this->roles),
            'tasks' => TaskResource::collection($this->tasks)
        ];
    }
}
