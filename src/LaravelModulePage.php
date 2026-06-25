<?php

declare(strict_types=1);

namespace BabelForge\BabelChromeLaravelModule;

/**
 * Builds the Laravel module page content.
 */
final readonly class LaravelModulePage
{
    /**
     * Renders the HTML document.
     *
     * @param string $moduleId        the module identifier
     * @param string $route           the module route
     * @param string $sourceUrl       the forwarded source URL
     * @param string $assetBaseUrl    the module asset base URL
     * @param string $assetTokenQuery the module asset token query string
     *
     * @return string the rendered HTML
     */
    public function render(string $moduleId, string $route, string $sourceUrl, string $assetBaseUrl, string $assetTokenQuery): string
    {
        $escapedModuleId = $this->escape($moduleId);
        $escapedRoute = $this->escape($route);
        $escapedSourceUrl = $this->escape($sourceUrl);
        $escapedStylesheetUrl = $this->escape(rtrim($assetBaseUrl, '/').'/assets/laravel.css'.$assetTokenQuery);

        return <<<HTML
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Laravel Module</title>
                <link rel="stylesheet" href="{$escapedStylesheetUrl}">
            </head>
            <body>
                <main>
                    <h1>Laravel Module</h1>
                    <p>This page is routed by Illuminate Routing inside a BabelChrome web module.</p>
                    <dl>
                        <dt>Module</dt>
                        <dd>{$escapedModuleId}</dd>
                        <dt>Route</dt>
                        <dd>{$escapedRoute}</dd>
                        <dt>Source URL</dt>
                        <dd>{$escapedSourceUrl}</dd>
                    </dl>
                </main>
            </body>
            </html>
            HTML;
    }

    /**
     * Escapes a string for HTML output.
     *
     * @param string $value the raw value
     *
     * @return string the escaped value
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
