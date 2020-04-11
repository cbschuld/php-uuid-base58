<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use cbschuld\UuidBase58;

final class EncodeDecodeTest extends TestCase
{
    public function testEncode1(): void
    {
        $u = "5afde89e-d1a2-4ee4-b922-9e57f5b3c30e";
        $v = UuidBase58::encode($u);
        $this->assertEquals("CEh6ymtJQevBoZEqwitJSy",$v);
    }
    public function testDecode1(): void
    {
        $u = "CEh6ymtJQevBoZEqwitJSy";
        $v = UuidBase58::decode($u);
        $this->assertEquals("5afde89e-d1a2-4ee4-b922-9e57f5b3c30e",$v);
    }
    public function testEncode2(): void
    {
        $u = "0d61af8f-7c5c-4a8a-8555-ca8eab6b3f21";
        $v = UuidBase58::encode($u);
        $this->assertEquals("2eqj2j96kCkiavo1yk1Kbv",$v);
    }
    public function testDecode2(): void
    {
        $u = "2eqj2j96kCkiavo1yk1Kbv";
        $v = UuidBase58::decode($u);
        $this->assertEquals("0d61af8f-7c5c-4a8a-8555-ca8eab6b3f21",$v);
    }

}