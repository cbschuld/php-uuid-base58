<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use cbschuld\UuidBase58;

final class CreateUuidTest extends TestCase
{
    public function testId(): void
    {
        $a = UuidBase58::id();
        $this->assertIsString($a);

        $b = UuidBase58::id();
        $this->assertIsString($b);

        $c = UuidBase58::id();
        $this->assertIsString($c);

        $d = UuidBase58::id();
        $this->assertIsString($d);

        $this->assertNotEquals($a,$b);
        $this->assertNotEquals($a,$c);
        $this->assertNotEquals($a,$d);
        $this->assertNotEquals($b,$c);
        $this->assertNotEquals($b,$d);
        $this->assertNotEquals($c,$d);
    }
}