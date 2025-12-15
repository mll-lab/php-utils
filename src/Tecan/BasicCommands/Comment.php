<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

class Comment extends Command
{
    public function __construct(
        private readonly string $comment
    ) {}

    public function toString(): string
    {
        return "C;{$this->comment}";
    }
}
