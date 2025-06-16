<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="AssignRoleRequest",
 *      description="AssignRoleRequest",
 *      type="object",
 *      required={"employee_id"}
 * )
 */
class AssignRoleRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="Role ID",
     *     description="Role ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $role_id;

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
            'role_id' => 'required|integer|exists:roles,id'
        ];
    }
}
