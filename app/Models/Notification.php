<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Уведомление",
 *     description="Notification model",
 *     @OA\Xml(
 *         name="Notification"
 *     )
 * )
 */
class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['employee_id', 'message', 'read'];

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
     *     title="Employee ID",
     *     description="Employee ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $employee_id;

    /**
     * @OA\Property(
     *     title="Сообщение уведомления",
     *     description="Сообщение уведомления",
     *     example="Задача #1, была переведена в статус 'В работе'",
     *     type="string"
     * )
     *
     * @var string
     */
    private string $message;

    /**
     * @OA\Property(
     *      title="Прочитано",
     *      description="Прочитано ли уведомление пользователем",
     *      type="boolean"
     * )
     *
     * @var string
     */
    private string $read;
}
