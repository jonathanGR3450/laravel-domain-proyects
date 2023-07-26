<?php

declare(strict_types=1);

namespace App\Domain\User\Aggregate;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\StringValueObject;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Id;
use App\Domain\User\ValueObjects\Identification;
use App\Domain\User\ValueObjects\IsVerified;
use App\Domain\User\ValueObjects\LastName;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Password;
use Illuminate\Support\Facades\Mail;

final class User
{
    private function __construct(
        private ?Id $id = null,
        private Name $name,
        private LastName $last_name,
        private Email $email,
        private Identification $identification,
        private ?IsVerified $is_verified,
        private Password $password,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        ?Id $id = null,
        Name $name,
        LastName $last_name,
        Email $email,
        Identification $identification,
        ?IsVerified $is_verified = null,
        Password $password,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $name,
            $last_name,
            $email,
            $identification,
            $is_verified,
            $password,
            $created_at,
            $updated_at
        );
    }

    public function id(): ?Id
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function lastName(): LastName
    {
        return $this->last_name;
    }

    public function identification(): Identification
    {
        return $this->identification;
    }

    public function isVerified(): ?IsVerified
    {
        return $this->is_verified;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->created_at;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updated_at;
    }

    public function updateName(string $name): void
    {
        $this->name = Name::fromString($name);
    }

    public function updateLastName(string $last_name): self
    {
        $this->last_name = LastName::fromString($last_name);
        return $this;
    }

    public function updateIdentification(int $identification): self
    {
        $this->identification = Identification::fromInteger($identification);
        return $this;
    }

    public function updateIsVerified(string $is_verified): self
    {
        $this->is_verified = IsVerified::fromString($is_verified);
        return $this;
    }

    public function updateEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function updatePassword(string $password): void
    {
        $this->password = Password::fromString($password);
    }

    public function sendEmailUserWasRegistered(): void
    {
        Mail::send('emails.mail', $this->asArray(), function ($message) {
            $message->to($this->email()->value())
                    ->subject("Welcome to {$this->name()->value()}");
            $message->from($this->email()->value());
        });
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()?->value(),
            'name' => $this->name()->value(),
            'last_name' => $this->lastName()->value(),
            'email' => $this->email()->value(),
            'identification' => $this->identification()->value(),
            'is_verified' => $this->isVerified()?->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value()
        ];
    }
}
