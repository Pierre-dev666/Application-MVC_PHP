<?php
use PHPUnit\Framework\TestCase;
use App\Core\Validator;

final class ValidatorTest extends TestCase
{
    public function testEmail(): void
    {
        $this->assertTrue(Validator::email('test@example.com'));
        $this->assertFalse(Validator::email('nope'));
    }
}
?>