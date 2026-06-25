<?php

declare(strict_types=1);

namespace BabelForge\BabelChromeLaravelModule\Tests;

use BabelForge\BabelChromeLaravelModule\LaravelModulePage;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Verifies the Laravel module page renderer.
 */
#[CoversClass(LaravelModulePage::class)]
final class LaravelModulePageTest extends TestCase
{
    /**
     * Ensures the page exposes BabelChrome runtime values.
     */
    public function testRenderShowsRuntimeValues(): void
    {
        $html = new LaravelModulePage()->render(
            'babelforge.laravel-module',
            'index',
            'https://example.com',
            'http://127.0.0.1:12345/module/babelforge.laravel-module/assets',
            '?token=test-token',
        );

        self::assertStringContainsString('Laravel Module', $html);
        self::assertStringContainsString('babelforge.laravel-module', $html);
        self::assertStringContainsString('https://example.com', $html);
        self::assertStringContainsString('/module/babelforge.laravel-module/assets/assets/laravel.css?token=test-token', $html);
    }
}
