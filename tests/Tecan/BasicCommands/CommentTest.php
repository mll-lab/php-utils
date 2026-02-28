<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\Comment;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    public function testFormatToString(): void
    {
        $text = 'foo. bar';
        $comment = new Comment($text);

        self::assertSame("C;{$text}", $comment->toString());
    }
}
