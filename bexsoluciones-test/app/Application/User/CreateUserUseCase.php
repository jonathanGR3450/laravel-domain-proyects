<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\User\Aggregate\User;
use App\Domain\User\Events\UserRegistered;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Id;
use App\Domain\User\ValueObjects\Identification;
use App\Domain\User\ValueObjects\IsVerified;
use App\Domain\User\ValueObjects\LastName;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Password;

final class CreateUserUseCase
{
    private UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function __invoke(
        string $name,
        string $last_name,
        string $email,
        int $identification,
        ?string $is_verified = null,
        string $password,
    ): User {
        $user = User::create(
            null,
            Name::fromString($name),
            LastName::fromString($last_name),
            Email::fromString($email),
            Identification::fromInteger($identification),
            !empty($is_verified) ? IsVerified::fromString($is_verified) : null,
            Password::fromString($password),
            DateTimeValueObject::now()
        );

        $this->userRepositoryInterface->create($user);

        # dispatched user register notify
        event(new UserRegistered($user));
        return $user;
    }
}
