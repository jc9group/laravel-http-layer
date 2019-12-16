<?php

namespace Jc9\PhpLibHttpLayer\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractHttpRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    final public function authorize(): bool
    {
        return true;
    }
}
