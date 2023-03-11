<?php

namespace Astrogoat\Courses\Models;

use Helix\Lego\Models\User;
use Laravel\Cashier\Billable;

class CashierUser
{
    use Billable;

    public function __construct(protected User $user)
    {
    }

    public function fromUser(User $user): static
    {
        return new static($user);
    }

    public function __get(string $name)
    {
        return $this->user->$name;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->user->$name(...$arguments);
    }
}
