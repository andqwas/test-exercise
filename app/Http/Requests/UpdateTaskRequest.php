<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *      title="UpdateTaskRequest",
 *      description="UpdateTaskRequest",
 *      type="object",
 *      required={"name", "title", "description"}
 * )
 */
class UpdateTaskRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Заголовок",
     *      description="Заголовок задачи",
     *      example="New Task"
     * )
     *
     * @var string
     */
    public string $title;

    /**
     * @OA\Property(
     *     title="Описание",
     *     description="Описание задачи",
     *     example="Test Description",
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *      title="Статус",
     *      description="Статус задачи",
     *      example="Выполнена"
     * )
     *
     * @var string
     */
    public string $status;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|string|in:К выполнению,В работе,Выполнена'
        ];
    }
}
