<?php

namespace App\Entity;

use App\Attribute\TrackableForEntityAssociations;
use App\Entity\Interfaces\TreeInterface;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Mapping\Annotation\Tree;
use Gedmo\Mapping\Annotation\TreeLevel;
use Gedmo\Mapping\Annotation\TreeParent;
use Gedmo\Mapping\Annotation\TreePath;
use Gedmo\Mapping\Annotation\TreePathSource;

#[Entity(repositoryClass: CategoryRepository::class)]
#[Tree(type: 'materializedPath'),]
class Category
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(type: 'integer')]
    #[TreePathSource]
    public $id;

    #[
        ManyToOne(targetEntity: self::class, inversedBy: 'children'),
        JoinColumn(name: 'parent_id', referencedColumnName: 'category_id', onDelete: 'cascade'),
        TreeParent,
    ]
    public ?Category $parent = null;

    #[
        Column(name: 'level', type: Types::INTEGER, nullable: true),
        TreeLevel,
    ]
    public ?int $level = null;

    #[
        Column(name: 'path', type: Types::STRING, nullable: false),
        TreePath(separator: '/', endsWithSeparator: false),
    ]
    public string $path = '';
}