<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TranslateHomeV2Components
{
    /**
     * Keep loaded maps in-memory for the current PHP process.
     *
     * @var array<string, array<string, string>|null>
     */
    private static array $mapCache = [];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldProcessResponse($response)) {
            return $response;
        }

        $locale = App::getLocale();

        if ($locale === 'fr') {
            return $response;
        }

        $map = $this->getMapForLocale($locale);

        if ($map === null || $map === []) {
            return $response;
        }

        $content = $response->getContent();

        if (! is_string($content) || $content === '') {
            return $response;
        }

        $response->setContent($this->translateHtmlContent($content, $map));

        return $response;
    }

    private function shouldProcessResponse(Response $response): bool
    {
        if (! $response instanceof IlluminateResponse) {
            return false;
        }

        $original = $response->original ?? null;
        if (! $original instanceof View) {
            return false;
        }

        if (! str_starts_with($original->name(), 'home-v2.')) {
            return false;
        }

        $contentType = strtolower((string) $response->headers->get('content-type', ''));

        return $contentType === '' || str_contains($contentType, 'text/html');
    }

    /**
     * @return array<string, string>|null
     */
    private function getMapForLocale(string $locale): ?array
    {
        if (array_key_exists($locale, self::$mapCache)) {
            return self::$mapCache[$locale];
        }

        $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');

        if (! is_file($path)) {
            self::$mapCache[$locale] = null;

            return null;
        }

        $map = require $path;

        if (! is_array($map)) {
            self::$mapCache[$locale] = null;

            return null;
        }

        self::$mapCache[$locale] = $map;

        return $map;
    }

    /**
     * @param array<string, string> $map
     */
    private function translateHtmlContent(string $html, array $map): string
    {
        $protectedBlocks = [];
        $placeholderPrefix = '__HOMEV2_TRANSLATE_BLOCK_';
        $placeholderIndex = 0;

        $html = preg_replace_callback('/<style\b[^>]*>[\s\S]*?<\/style>/iu', function (array $matches) use (&$protectedBlocks, $placeholderPrefix, &$placeholderIndex): string {
            $token = $placeholderPrefix . $placeholderIndex . '__';
            $protectedBlocks[$token] = $matches[0];
            $placeholderIndex++;

            return $token;
        }, $html) ?? $html;

        $html = preg_replace_callback('/<script\b[^>]*>[\s\S]*?<\/script>/iu', function (array $matches) use (&$protectedBlocks, $placeholderPrefix, &$placeholderIndex, $map): string {
            $token = $placeholderPrefix . $placeholderIndex . '__';
            $protectedBlocks[$token] = $this->translateScriptBlock($matches[0], $map);
            $placeholderIndex++;

            return $token;
        }, $html) ?? $html;

        $html = preg_replace_callback('/\b(title|aria-label|placeholder|alt)\s*=\s*("|\')(.*?)\2/isu', function (array $matches) use ($map): string {
            $translated = $this->translateAttributeValue($matches[3], $map);

            return $matches[1] . '=' . $matches[2] . $translated . $matches[2];
        }, $html) ?? $html;

        $html = preg_replace_callback('/>([^<]+)</u', function (array $matches) use ($map): string {
            $translated = $this->translateTextNodeValue($matches[1], $map);

            return '>' . $translated . '<';
        }, $html) ?? $html;

        if ($protectedBlocks !== []) {
            $html = strtr($html, $protectedBlocks);
        }

        return $html;
    }

    /**
     * @param array<string, string> $map
     */
    private function translateExactValue(string $value, array $map): string
    {
        return $map[$value] ?? $value;
    }

    /**
     * @param array<string, string> $map
     */
    private function translateAttributeValue(string $value, array $map): string
    {
        if (array_key_exists($value, $map)) {
            return $map[$value];
        }

        $trimmed = trim($value);
        if ($trimmed !== '' && array_key_exists($trimmed, $map)) {
            return $this->preserveOuterWhitespace($value, $map[$trimmed]);
        }

        $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($decoded === $value) {
            return $value;
        }

        if (array_key_exists($decoded, $map)) {
            return htmlspecialchars($map[$decoded], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $decodedTrimmed = trim($decoded);
        if ($decodedTrimmed !== '' && array_key_exists($decodedTrimmed, $map)) {
            $translatedDecoded = $this->preserveOuterWhitespace($decoded, $map[$decodedTrimmed]);

            return htmlspecialchars($translatedDecoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $value;
    }

    /**
     * @param array<string, string> $map
     */
    private function translateTextNodeValue(string $value, array $map): string
    {
        if (array_key_exists($value, $map)) {
            return $map[$value];
        }

        $trimmed = trim($value);
        if ($trimmed === '' || ! array_key_exists($trimmed, $map)) {
            return $value;
        }

        if (! preg_match('/^(\s*)(.*?)(\s*)$/us', $value, $parts)) {
            return $map[$trimmed];
        }

        return $this->preserveOuterWhitespace($value, $map[$trimmed]);
    }

    private function preserveOuterWhitespace(string $original, string $translated): string
    {
        if (! preg_match('/^(\s*)(.*?)(\s*)$/us', $original, $parts)) {
            return $translated;
        }

        return $parts[1] . $translated . $parts[3];
    }

    /**
     * @param array<string, string> $map
     */
    private function translateScriptBlock(string $scriptBlock, array $map): string
    {
        if (! preg_match('/^(\s*<script\b[^>]*>)([\s\S]*)(<\/script>\s*)$/iu', $scriptBlock, $parts)) {
            return $scriptBlock;
        }

        $openTag = $parts[1];
        $script = $parts[2];
        $closeTag = $parts[3];

        $translatedScript = preg_replace_callback('/(["\'])(?:\\\\.|(?!\1).)*\1/su', function (array $matches) use ($map): string {
            $quoted = $matches[0];
            $quote = $quoted[0];
            $inner = substr($quoted, 1, -1);

            if (! is_string($inner) || $inner === '') {
                return $quoted;
            }

            $decoded = stripcslashes($inner);
            $source = array_key_exists($decoded, $map) ? $decoded : (array_key_exists($inner, $map) ? $inner : null);

            if ($source === null) {
                return $quoted;
            }

            if (! $this->shouldTranslateScriptString($source)) {
                return $quoted;
            }

            $translated = $map[$source] ?? $source;
            $escaped = addcslashes($translated, "\\{$quote}\n\r\t\v\f");

            return $quote . $escaped . $quote;
        }, $script) ?? $script;

        return $openTag . $translatedScript . $closeTag;
    }

    private function shouldTranslateScriptString(string $value): bool
    {
        $trimmed = trim($value);

        if ($trimmed === '' || mb_strlen($trimmed) < 3) {
            return false;
        }

        // Avoid translating IDs, slugs, css classes, file names, or pure code-like tokens.
        if (preg_match('/^[a-z0-9._\\/-]+$/', $trimmed)) {
            return false;
        }

        if (preg_match('/^(?:true|false|null|undefined|all|none|yes|no|left|right|top|bottom)$/i', $trimmed)) {
            return false;
        }

        if (preg_match('/^(?:fas|far|fal|fab|fa-[a-z0-9-]+)$/i', $trimmed)) {
            return false;
        }

        return (bool) preg_match('/\p{L}/u', $trimmed);
    }
}
