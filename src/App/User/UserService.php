<?php

namespace App\User;

use Ramsey\Uuid\Uuid;

class UserService
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getOne(User $user): User
    {
        if ($user->getId()) {
            $column = 'id';
            $value = $user->getId();
        } else if ($user->getEmailAddress()) {
            $column = 'email';
            $value = $user->getEmailAddress();
        }

        $q = $this->database->prepare("
            SELECT
                `users`.`id` as id,
                `users`.`name` as name,
                `users`.`email` as email_address,
                `users`.`password` as password,
                `users`.`created_at` as created_at,
                `users`.`updated_at` as updated_at
            FROM `users`
            WHERE `{$column}` = :value
            LIMIT 1
        ");

        $q->execute([
            ':value' => $value,
        ]);

        if (!$q->rowCount()) {
            // throw 404
        }

        $data = $q->fetch();
        return $this->mapToModel($data);
    }

    public function create(User $model)
    {
        $id = Uuid::uuid4()->toString();
        $model->setId($id);

        $statement = $this->database->prepare('
            INSERT INTO `users` (
                `id`, `name`, `email`, `password`
            ) VALUES (
                :id, :name, :email_address, :password
            )
        ');

        $statement->execute([
            ':id' => $model->getId(),
            ':name' => $model->getName(),
            ':email_address' => $model->getEmailAddress(),
            ':password' => $model->getPassword(),
        ]);

        return $model;
    }

    public function update(User $model): User
    {
        $statement = $this->database->prepare('
            UPDATE `users`
            SET
                `name` = :name,
                `email` = :email_address,
                `password` = :password
            WHERE `id` = :id
            LIMIT 1
        ');

        $statement->execute([
            ':id' => $model->getId(),
            ':name' => $model->getName(),
            ':email_address' => $model->getEmailAddress(),
            ':password' => $model->getPassword(),
        ]);

        return $model;
    }

    private function mapToModel(object $data): User
    {
        return (new User())
            ->setId($data->id)
            ->setName($data->name)
            ->setEmailAddress($data->email_address)
            ->setPassword($data->password)
            ->setCreatedAt(new \DateTime($data->created_at))
            ->setUpdatedAt(new \DateTime($data->updated_at));
    }
}
