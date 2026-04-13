<?php

declare(strict_types=1);

/**
 * Application requirements checker.
 *
 * Returns an array with check results. Called from public/index.php before the framework boots.
 *
 * If any mandatory requirement fails, index.php renders a standalone error page instead of starting the application.
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 *
 * @return array{requirements: list<array{name: string, mandatory: bool, passed: bool, by: string, memo: string}>, summary: array{total: int, passed: int, failed: int, warnings: int, errors: int}, php: array{version: string, sapi: string, os: string}}
 */
return (static function (): array {
    $gdMemo = 'Either GD with FreeType or ImageMagick with PNG support is required for CAPTCHA.';
    $imagickMemo = $gdMemo;
    $gdOK = false;
    $imagickOK = false;

    if (extension_loaded('imagick')) {
        $imagick = new Imagick();
        $imagickFormats = $imagick->queryFormats('PNG');

        if (in_array('PNG', $imagickFormats, true)) {
            $imagickOK = true;
        } else {
            $imagickMemo = 'Imagick should be installed with PNG support for CAPTCHA.';
        }
    }

    if (extension_loaded('gd')) {
        $gdInfo = gd_info();

        if (!empty($gdInfo['FreeType Support'])) {
            $gdOK = true;
        } else {
            $gdMemo = 'GD should be installed with FreeType support for CAPTCHA.';
        }
    }

    $checks = [
        // mandatory: bundled and enabled by default, but can be excluded at compile time.
        ['PDO extension', true, extension_loaded('pdo'), 'Database', 'Bundled and default-enabled. Required for all database operations.'],
        ['PDO SQLite extension', true, extension_loaded('pdo_sqlite'), 'Database', 'Bundled and default-enabled. Required for SQLite database.'],
        ['DOM extension', true, extension_loaded('dom'), 'Framework', 'Bundled and default-enabled. Required for HTML and XML processing.'],

        // mandatory: bundled but requires --enable-mbstring at compile time.
        ['MBString extension', true, extension_loaded('mbstring'), 'Framework', 'Bundled, requires --enable-mbstring. Required for multibyte string processing.'],

        // optional: database drivers (not bundled by default, must opt-in).
        ['PDO MySQL extension', false, extension_loaded('pdo_mysql'), 'Database', 'Not default-enabled. Required for MySQL database.'],
        ['PDO PostgreSQL extension', false, extension_loaded('pdo_pgsql'), 'Database', 'Not default-enabled. Required for PostgreSQL database.'],

        // optional: bundled but requires opt-in at compile time.
        ['Intl extension', false, extension_loaded('intl'), 'Internationalization', 'Not default-enabled. Required for advanced formatting and transliteration.'],
        ['cURL extension', false, extension_loaded('curl'), 'HTTP client', 'Not default-enabled. Required for HTTP requests.'],

        // optional: image processing for CAPTCHA.
        ['GD extension with FreeType', false, $gdOK, 'Captcha', $gdMemo],
        ['ImageMagick with PNG support', false, $imagickOK, 'Captcha', $imagickMemo],

        // optional: security recommendations (php.ini settings).
        ['expose_php disabled', false, !ini_get('expose_php'), 'Security', '"expose_php" should be disabled in php.ini.'],
        ['allow_url_include disabled', false, !ini_get('allow_url_include'), 'Security', '"allow_url_include" should be disabled in php.ini.'],
    ];

    $requirements = [];
    $passed = 0;
    $warnings = 0;
    $errors = 0;

    foreach ($checks as [$name, $mandatory, $condition, $by, $memo]) {
        $ok = (bool) $condition;
        $requirements[] = [
            'name' => $name,
            'mandatory' => $mandatory,
            'passed' => $ok,
            'by' => $by,
            'memo' => $memo,
        ];

        if ($ok) {
            $passed++;
        } elseif ($mandatory) {
            $errors++;
        } else {
            $warnings++;
        }
    }

    return [
        'requirements' => $requirements,
        'summary' => [
            'total' => count($requirements),
            'passed' => $passed,
            'failed' => $errors + $warnings,
            'warnings' => $warnings,
            'errors' => $errors,
        ],
        'php' => [
            'version' => PHP_VERSION,
            'sapi' => PHP_SAPI,
            'os' => PHP_OS,
        ],
    ];
})();
