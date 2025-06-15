<?php

namespace App\Rules;

use App\Models\Employee;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmployeeNotOnVacation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $employee = Employee::find($value);

        if (!$employee) {
            $fail('Сотрудник не найден.');
            return;
        }

        if ($employee->status === 'В отпуске') {
            $fail('Нельзя назначить задачу сотруднику в отпуске.');
        }
    }
}
