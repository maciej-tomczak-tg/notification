<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Application\Ports\HasCustomerIdentity;
use App\Application\Ports\HasEmail;
use App\Application\Ports\HasPhone;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\CustomerInfo;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;

class CustomerDTO implements HasCustomerIdentity, HasEmail, HasPhone
{
    public function __construct(
        private string $customerId,
        private string $email,
        private string $phoneNo
    ) {
    }

    public function toValueObject(): CustomerInfo
    {
        return new CustomerInfo(
            new CustomerId($this->customerId),
            new Email($this->email),
            new Phone($this->phoneNo)
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNo;
    }
}
