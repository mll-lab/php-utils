<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class DestTaqMan extends BaseRack
{
    public function type(): string
    {
        return '96 Well PCR TaqMan';
    }

    public function name(): string
    {
        return 'DestTaqMan';
    }

    public function positionCount(): int
    {
        return 96;
    }
}
