<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     title="Роль",
 *     description="RoleResource model",
 *     @OA\Xml(
 *         name="RoleResource"
 *     )
 * )
 */
class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = ['name', 'title'];

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
     *      title="Имя роли",
     *      description="Имя роли",
     *      example="manager"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *      title="Название роли",
     *      description="Название роли",
     *      example="Менеджер"
     * )
     *
     * @var string
     */
    private string $title;

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_roles', 'role_id', 'employee_id');
    }
}
