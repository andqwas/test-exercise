<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="GetNotificationRequest",
 *      description="GetNotificationRequest",
 *      type="object",
 *      required={"employee_id"}
 * )
 */
class GetNotificationRequest extends FormRequest
{
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
    public int $employee_id;
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
            'employee_id' => 'required|integer|exists:employees,id'
        ];
    }
}
