<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="UpdateEmployeeRequest",
 *      description="UpdateEmployeeRequest",
 *      type="object",
 *      required={"name", "status"}
 * )
 */
class UpdateEmployeeRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Имя",
     *      description="Имя сотрудника",
     *      example="Updated Employee"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email сотрудника",
     *     example="damien@example2.net",
     *     format="email",
     *     type="string"
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="Статус",
     *      description="Статус сотрудника",
     *      example="В отпуске"
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
            'name' => 'required|string|min:2|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'required|string|in:Работает,В отпуске'
        ];
    }
}
