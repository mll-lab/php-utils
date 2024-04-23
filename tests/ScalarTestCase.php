<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use Composer\InstalledVersions;
use PHPUnit\Framework\TestCase;

abstract class ScalarTestCase extends TestCase
{
    protected function setUp(): void
    {
        if (! InstalledVersions::isInstalled('mll-lab/graphql-php-scalars')) {
            self::markTestSkipped('This test requires mll-lab/graphql-php-scalars to be installed.');
        }

        parent::setUp();
    }
}
