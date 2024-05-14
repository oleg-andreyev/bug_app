<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Tree\Entity\Repository\MaterializedPathRepository;

class CategoryRepository extends MaterializedPathRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        /** @var EntityManagerInterface $manager */
        $manager = $registry->getManagerForClass(Category::class);

        parent::__construct($manager, $manager->getClassMetadata(Category::class));
    }
}