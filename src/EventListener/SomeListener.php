<?php

namespace App\EventListener;

use App\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;

#[AsDoctrineListener(Events::onFlush)]
#[AsDoctrineListener(Events::postFlush)]
#[AsDoctrineListener(Events::onClear)]
class SomeListener
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function onFlush() {

    }

    public function postFlush()
    {

    }

    public function onClear()
    {

    }
}