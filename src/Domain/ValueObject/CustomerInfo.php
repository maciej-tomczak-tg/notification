<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class CustomerInfo
{
    public function __construct(private CustomerId $customerId, private Email $email, private Phone $phone)
    {
    }

    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
