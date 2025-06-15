<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     title="Сотрудник",
 *     description="Employee model",
 *     @OA\Xml(
 *         name="Employee"
 *     )
 * )
 */
class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = ['name', 'email', 'status'];

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
     *      title="Имя",
     *      description="Имя сотрудника",
     *      example="Cayla Kling"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email сотрудника",
     *     example="kiehn.damien@example.net",
     *     format="email",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $email;

    /**
     * @OA\Property(
     *      title="Статус",
     *      description="Статус сотрудника",
     *      example="Работает"
     * )
     *
     * @var string
     */
    private string $status;

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_tasks', 'employee_id', 'task_id')->withTimestamps();
    }
}
