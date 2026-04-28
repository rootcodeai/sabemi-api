<?php

namespace App\Support\FormRequest;

trait HasValidatedData
{
    public function validatedData(): array
    {
        return $this->validated();
    }
}
