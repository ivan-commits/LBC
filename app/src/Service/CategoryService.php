<?php

namespace App\Service;

use App\Entity\Category;

class CategoryService extends HelperService
{
    public function getCategoryEntity(string $name): ?Category
    {
        return $this->doctrine->getRepository(Category::class)->findOneBy(['name' => $name]);
    }
}