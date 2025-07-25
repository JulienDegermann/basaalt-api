<?php

namespace App\Service\Interface;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findOneBy(array $criteria, ?array $orderBy = null);

    public function find($id);

    public function findAdmins(): array;
    
    public function findBandMembers(): array;
}
