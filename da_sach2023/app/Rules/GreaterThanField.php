<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThanField implements Rule
{
    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function passes($attribute, $value)
    {
        $otherFieldValue = request($this->field);

        if ($otherFieldValue === null) {
            return false; // The other field is not set, so the check cannot be performed.
        }

        return $value > $otherFieldValue;
    }

    public function message()
    {
        return 'Trường giá tối đa phải lớn hơn trường giá tối thiểu';
    }
}
