# Testing

This package provides a consistent set of [Composer](https://getcomposer.org/) scripts for local validation.

Tool references:

- [Codeception](https://codeception.com/) for unit tests.
- [PHPCodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer) for code style checks.
- [PHPStan](https://phpstan.org/) for static analysis.

## Code style checks (PHPCodeSniffer)

Run code style checks.

```bash
composer cs
```

Fix code style issues.

```bash
composer cs-fix
```

## Static analysis (PHPStan)

Run static analysis.

```bash
composer static
```

## Unit tests (Codeception)

Run the full test suite.

```bash
composer tests
```

## Passing extra arguments

Composer scripts support forwarding additional arguments using `--`.

Run Codeception with a specific suite.

```bash
composer tests -- Acceptance
```

Run PHPStan with a different memory limit.

```bash
composer static -- --memory-limit=512M
```
