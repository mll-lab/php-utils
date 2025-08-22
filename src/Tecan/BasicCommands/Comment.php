<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

class Comment extends Command
{
    private readonly string $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    public function toString(): string
    {
        return "C;{$this->comment}";
    }
}
