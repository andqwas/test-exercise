<?php

namespace App\Models;

use App\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Задача",
 *     description="Task model",
 *     @OA\Xml(
 *         name="Task"
 *     )
 * )
 */
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    use Filterable;

    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'status'];

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *      title="Заголовок",
     *      description="Заголовок задачи",
     *      example="Alteration Tailor"
     * )
     *
     * @var string
     */
    private string $title;

    /**
     * @OA\Property(
     *     title="Описание",
     *     description="Описание задачи",
     *     example="Rerum ipsum incidunt est minima nesciunt. Sit ut in sunt harum ducimus. Amet sed dolorum quia ut veritatis. Ad in nostrum alias animi rem nemo. Reiciendis velit provident vel voluptas et.",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $description;

    /**
     * @OA\Property(
     *      title="Статус",
     *      description="Статус задачи",
     *      example="В работе"
     * )
     *
     * @var string
     */
    private string $status;

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_tasks', 'task_id', 'employee_id')->withTimestamps();
    }

    public function hasEmployee(int $employeeId): bool
    {
        return $this->employees()->where('employee_id', $employeeId)->exists();
    }
}
