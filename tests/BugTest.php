<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class BugTest extends WebTestCase
{
    public function testDenormalizeRowData(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $serializer = $container->get(SerializerInterface::class);

        $row = [
            'ean' => '1234567890123',
            'segments[Default]' => '123.45',
        ];

        $result = $serializer->denormalize($row, Target::class);

        $this->assertInstanceOf(Target::class, $result);
        $this->assertCount(1, $result->getSegments());
        $this->assertEquals(['Default' => '123.45'], $result->getSegments());
    }
}

class Target {
    private string $ean = '';
    private array $segments = [];

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function setSegments(array $segments): void
    {
        $this->segments = $segments;
    }

    public function getEan(): string
    {
        return $this->ean;
    }

    public function setEan(string $ean): void
    {
        $this->ean = $ean;
    }
}
