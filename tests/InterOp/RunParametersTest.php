<?php declare(strict_types=1);

namespace MLL\Utils\Tests\InterOp;

use MLL\Utils\InterOp\InterOpException;
use MLL\Utils\InterOp\RunParameters;
use PHPUnit\Framework\TestCase;

final class RunParametersTest extends TestCase
{
    public function testThrowsOnUnknownDeviceType(): void
    {
        $this->expectException(InterOpException::class);

        // @phpstan-ignore argument.type (intentionally invalid input for error path test)
        new RunParameters(['UnknownKey' => 'value']);
    }
}
