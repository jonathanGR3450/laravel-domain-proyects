<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\User\Aggregate\User;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserSearchCriteria;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Id;
use App\Domain\User\ValueObjects\Identification;
use App\Domain\User\ValueObjects\IsVerified;
use App\Domain\User\ValueObjects\LastName;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Password;
use App\Infrastructure\Laravel\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function create(User $user): void
    {
        $userModel = new ModelsUser();

        $userModel->id = $user->id()->value();
        $userModel->name = $user->name()->value();
        $userModel->last_name = $user->lastName()->value();
        $userModel->email = $user->email()->value();
        $userModel->identification = $user->identification()->value();
        $userModel->is_verified = $user->isVerified()?->value();
        $userModel->password = Hash::make($user->password()->value());
        $userModel->created_at = DateTimeValueObject::now()->value();

        $userModel->save();
    }

    public function update(User $user): void
    {
        $userModel = ModelsUser::find($user->id()->value());

        $userModel->id = $user->id()->value();
        $userModel->name = $user->name()->value();
        $userModel->last_name = $user->lastName()->value();
        $userModel->email = $user->email()->value();
        $userModel->identification = $user->identification()->value();
        $userModel->is_verified = $user->isVerified()?->value();
        $userModel->updated_at = DateTimeValueObject::now()->value();

        $userModel->save();
    }

    public function findById(Id $id): User
    {
        $userModel = ModelsUser::find($id->value());

        if (empty($userModel)) {
            throw new UserNotFoundException('User does not exist');
        }

        return self::map($userModel);
    }

    public function findByIdGetModel(Id $id): ModelsUser
    {
        $userModel = ModelsUser::find($id->value());

        if (empty($userModel)) {
            throw new UserNotFoundException('User does not exist');
        }

        return $userModel;
    }

    public function searchById(Id $id): ?User
    {
        $userModel = ModelsUser::find($id->value());

        return $userModel != null ? self::map($userModel) : null;
    }

    public function searchByCriteria(UserSearchCriteria $criteria): array
    {
        $userModel = new ModelsUser();

        if (!empty($criteria->email())) {
            $userModel = $userModel->where('email', 'ILIKE', "%" . $criteria->email() . "%");
        }

        if (!empty($criteria->name())) {
            $userModel = $userModel->where('name', 'ILIKE', "%" . $criteria->name() . "%");
        }

        if (!empty($criteria->identification())) {
            $userModel = $userModel->where('identification', 'ILIKE', "%" . $criteria->identification() . "%");
        }

        if ($criteria->pagination() !== null) {
            $userModel = $userModel->take($criteria->pagination()->limit()->value())
                                    ->skip($criteria->pagination()->offset()->value());
        }

        if ($criteria->sort() !== null) {
            $userModel = $userModel->orderBy($criteria->sort()->field()->value(), $criteria->sort()->direction()->value());
        }

        return array_map(
            static fn (ModelsUser $user) => self::map($user),
            $userModel->get()->all()
        );
    }

    public function delete(User $user): void
    {
        $userModel = ModelsUser::find($user->id()->value());

        $userModel->delete();
    }

    public function getAuthUser(): User|bool
    {
        if (!$user = Auth::user()) {
            return false;
        }
        return $this->map($user);
    }

    public static function map(ModelsUser $model): User
    {
        return User::create(
            Id::fromInteger($model->id),
            Name::fromString($model->name),
            LastName::fromString($model->last_name),
            Email::fromString($model->email),
            Identification::fromInteger($model->identification),
            !empty($model->is_verified) ? IsVerified::fromString($model->is_verified) : null,
            Password::fromString($model->password),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}
