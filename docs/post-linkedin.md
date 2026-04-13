**Yii2 Branch 22: Extracting jQuery from a 12-Year-Old Framework**

Today marks a significant milestone for the Yii2 PHP framework. After years of having jQuery tightly coupled into the core, branch 22 finally extracts it into a standalone extension: `yiisoft/yii2-jquery`.

**Why this matters:**

The Yii2 framework has served thousands of projects since 2014, but its hard dependency on jQuery and Bootstrap CSS was becoming a liability. Modern applications need flexibility -- React, Vue, htmx, or no JS framework at all. Branch 22 makes the framework truly agnostic.

**Core framework changes:**
- jQuery integration extracted to `yiisoft/yii2-jquery`
- View class ready/load wrappers rewritten with vanilla JS event listeners
- Asset management migrated from Bower to NPM (via php-forge/foxy)
- Removed legacy support: HHVM, CUBRID, XCache, ZendDataCache
- All PHP < 8.3 version guards removed
- Runtime autoloader removed in favor of Composer-only autoloading
- PHP 8.4 compatibility fixes

**Updated application template (yii2-app-basic):**
- Complete user management system (registration, email verification, password reset)
- SQLite database with migrations out of the box
- RBAC authorization
- Admin panel with GridView + jQuery/PJAX filtering
- Bootstrap 5 with dark/light theme toggle
- Automatic environment requirements checker
- PHPStan (level max) and ECS code standards
- Comprehensive test coverage with Codeception

**The AI collaboration story:**

This work was accomplished through a collaboration between four AI coding tools:

- **Claude Code** (Anthropic) -- Deep architectural reasoning, complex refactors, and multi-file implementations
- **Codex** (OpenAI) -- Rapid code generation and pattern completion
- **GitHub Copilot** (Microsoft) -- Inline suggestions and code completion during development
- **CodeRabbit AI** -- Automated code reviews on every pull request, catching edge cases, security issues, and suggesting improvements before merge

Each brought different strengths to the table. Together, they helped modernize a mature codebase that would have taken significantly longer with traditional approaches alone.

The future of open source development is human-directed, AI-assisted. This project is living proof.

#PHP #Yii2 #OpenSource #WebDevelopment #SoftwareEngineering #AI #CodeReview #DeveloperTools
