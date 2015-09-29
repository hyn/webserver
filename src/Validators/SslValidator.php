<?php

namespace HynMe\Webserver\Validators;

use HynMe\Framework\Validators\AbstractValidator;

class SslValidator extends AbstractValidator
{
    protected $rules = [
        'tenant_id'        => ['required', 'exists:tenants,id'],
        'certificate'      => ['required', 'string'],
        'authority_bundle' => ['required', 'string'],
        'key'              => ['required', 'string'],
        'wildcard'         => ['boolean'],
    ];
}
