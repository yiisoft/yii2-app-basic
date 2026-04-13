<?php

declare(strict_types=1);

/**
 * Standalone requirements error page.
 *
 * Rendered directly from public/index.php when mandatory requirements fail, before the framework loads.
 * This file must NOT depend on Yii, Bootstrap, or any vendor code.
 *
 * @var array{requirements: list<array{
 *   name: string,
 *   mandatory: bool,
 *   passed: bool,
 *   by: string,
 *   memo: string}>,
 *   summary: array{
 *     total: int,
 *     passed: int,
 *     failed: int,
 *     warnings: int,
 *     errors: int
 *   },
 *   php: array{
 *     version: string,
 *     sapi: string,
 *     os: string
 *   }
 * } $result
 *
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

$esc = static fn (string $v): string => htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$passedPct = $result['summary']['total'] > 0
    ? round($result['summary']['passed'] / $result['summary']['total'] * 100)
    : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Requirements - Yii2 Application</title>
    <style>
        *,*::before,*::after{box-sizing:border-box}

        /* Light theme (default) */
        :root{
            --bg:#f0f2f5;--surface:#fff;--border:#d0d7de;
            --text:#1f2328;--muted:#656d76;--dim:#8b949e;
            --green:#1a7f37;--yellow:#9a6700;--red:#cf222e;
            --hover:rgba(0,0,0,.03);
            --shadow:0 4px 24px rgba(0,0,0,.1);
            --badge-pass-bg:rgba(26,127,55,.1);--badge-fail-bg:rgba(207,34,46,.1);--badge-warn-bg:rgba(154,103,0,.1);
            --brand-from:#40b3d8;--brand-to:#83c933;
        }

        /* Dark theme */
        @media(prefers-color-scheme:dark){
            :root{
                --bg:#0d1117;--surface:#161b22;--border:#30363d;
                --text:#e6edf3;--muted:#8b949e;--dim:#484f58;
                --green:#3fb950;--yellow:#d29922;--red:#f85149;
                --hover:rgba(255,255,255,.03);
                --shadow:0 0 0 1px var(--border),0 4px 24px rgba(0,0,0,.4);
                --badge-pass-bg:rgba(63,185,80,.15);--badge-fail-bg:rgba(248,81,73,.15);--badge-warn-bg:rgba(210,153,34,.15);
            }
        }

        /* Manual dark override via data attribute */
        [data-bs-theme="dark"]{
            --bg:#0d1117;--surface:#161b22;--border:#30363d;
            --text:#e6edf3;--muted:#8b949e;--dim:#484f58;
            --green:#3fb950;--yellow:#d29922;--red:#f85149;
            --hover:rgba(255,255,255,.03);
            --shadow:0 0 0 1px var(--border),0 4px 24px rgba(0,0,0,.4);
            --badge-pass-bg:rgba(63,185,80,.15);--badge-fail-bg:rgba(248,81,73,.15);--badge-warn-bg:rgba(210,153,34,.15);
        }

        /* Manual light override via data attribute */
        [data-bs-theme="light"]{
            --bg:#f0f2f5;--surface:#fff;--border:#d0d7de;
            --text:#1f2328;--muted:#656d76;--dim:#8b949e;
            --green:#1a7f37;--yellow:#9a6700;--red:#cf222e;
            --hover:rgba(0,0,0,.03);
            --shadow:0 4px 24px rgba(0,0,0,.1);
            --badge-pass-bg:rgba(26,127,55,.1);--badge-fail-bg:rgba(207,34,46,.1);--badge-warn-bg:rgba(154,103,0,.1);
        }

        body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem}
        .card{max-width:960px;width:100%;border-radius:1rem;overflow:hidden;display:grid;grid-template-columns:5fr 7fr;box-shadow:var(--shadow)}
        .brand{background:linear-gradient(135deg,var(--brand-from) 0%,#3a9cbd 40%,var(--brand-to) 100%);position:relative;padding:2.5rem;display:flex;flex-direction:column;justify-content:space-between;color:#fff;min-height:520px}
        .brand::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 20% 80%,rgba(241,138,42,.25) 0%,transparent 50%),radial-gradient(circle at 80% 20%,rgba(131,201,51,.2) 0%,transparent 40%);pointer-events:none}
        .brand *{position:relative}
        .brand-title{font-size:1.75rem;font-weight:700;line-height:1.3;margin:0 0 .75rem}
        .brand-text{font-size:.9rem;opacity:.75;margin:0}
        .brand-meta{font-size:.65rem;font-weight:600;letter-spacing:.12em;opacity:.75}
        .brand-meta-dot{font-size:.65rem;opacity:.5;margin:0 .25rem}
        .main{background:var(--surface);padding:2rem 2.5rem;display:flex;flex-direction:column;justify-content:center}
        .summary{padding-bottom:.75rem;border-bottom:1px solid var(--border);margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem}
        .status-dot{display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--red);flex-shrink:0}
        .status-label{font-weight:600;font-size:.875rem;margin-left:.75rem}
        .counters{display:flex;gap:1rem}
        .counter-val{font-size:1.1rem;font-weight:700;margin-right:.25rem}
        .counter-label{font-size:.65rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)}
        .progress-bar{height:3px;background:var(--border);border-radius:2px;overflow:hidden;margin-top:.5rem}
        .progress-fill{height:100%;border-radius:2px;background:var(--red);transition:width .4s}
        table{width:100%;border-collapse:collapse;font-size:.84rem}
        thead th{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);padding:.75rem .65rem;border-bottom:2px solid var(--border);text-align:left;white-space:nowrap}
        tbody td{padding:.65rem;border-bottom:1px solid var(--border);vertical-align:middle}
        tbody tr:last-child td{border-bottom:none}
        tbody tr:hover td{background:var(--hover)}
        .name{font-weight:500}
        .memo{color:var(--dim);font-size:.78rem;margin-top:.25rem}
        .by{color:var(--muted);font-size:.78rem}
        .badge{display:inline-block;font-size:.7rem;font-weight:600;padding:.35em .75em;border-radius:1rem;letter-spacing:.02em;text-align:center}
        .badge-pass{background:var(--badge-pass-bg);color:var(--green)}
        .badge-fail{background:var(--badge-fail-bg);color:var(--red)}
        .badge-warn{background:var(--badge-warn-bg);color:var(--yellow)}
        .text-pass{color:var(--green)}.text-warn{color:var(--yellow)}.text-fail{color:var(--red)}
        .table-wrap{overflow-x:auto}
        .status-col{width:80px;text-align:center}
        @media(max-width:768px){
            .card{grid-template-columns:1fr}
            .brand{display:none}
            .main{padding:1.5rem}
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Brand panel -->
    <div class="brand">
        <div>
            <img src="images/yii3_full_white_for_dark.svg" alt="Yii Framework" height="36" style="margin-bottom:1.5rem">
        </div>
        <div>
            <h1 class="brand-title">System<br>Check</h1>
            <p class="brand-text">Your server does not meet the mandatory requirements to run this application.</p>
        </div>
        <div style="margin-top:1.5rem">
            <span style="display:inline-block;background:rgba(255,255,255,.2);border-radius:1rem;padding:.4em 1em;font-size:.78rem;font-weight:500;margin-bottom:.75rem">
                PHP <?= $esc($result['php']['version']) ?> &middot; <?= $esc(strtoupper($result['php']['sapi'])) ?>
            </span>
            <br>
            <span class="brand-meta">YII2</span>
            <span class="brand-meta-dot">&middot;</span>
            <span class="brand-meta">JQUERY</span>
            <span class="brand-meta-dot">&middot;</span>
            <span class="brand-meta">BOOTSTRAP5</span>
        </div>
    </div>

    <!-- Requirements panel -->
    <div class="main">
        <div class="summary">
            <div style="display:flex;align-items:center">
                <span class="status-dot"></span>
                <span class="status-label"><?= $result['summary']['errors'] ?> error(s)</span>
            </div>
            <div class="counters">
                <span><span class="counter-val text-pass"><?= $result['summary']['passed'] ?></span><span class="counter-label">passed</span></span>
                <?php if ($result['summary']['warnings'] > 0): ?>
                <span><span class="counter-val text-warn"><?= $result['summary']['warnings'] ?></span><span class="counter-label">warnings</span></span>
                <?php endif; ?>
                <span><span class="counter-val text-fail"><?= $result['summary']['errors'] ?></span><span class="counter-label">errors</span></span>
            </div>
        </div>
        <div class="progress-bar"><div class="progress-fill" style="width:<?= $passedPct ?>%"></div></div>

        <div class="table-wrap" style="margin-top:1rem">
            <table>
                <thead>
                    <tr>
                        <th>Requirement</th>
                        <th>Required by</th>
                        <th class="status-col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result['requirements'] as $req): ?>
                    <tr>
                        <td>
                            <span class="name"><?= $esc($req['name']) ?></span>
                            <?php if (!$req['passed'] && $req['memo'] !== ''): ?>
                                <div class="memo"><?= $esc($req['memo']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="by"><?= $esc($req['by']) ?></td>
                        <td class="status-col">
                            <?php if ($req['passed']): ?>
                                <span class="badge badge-pass">Pass</span>
                            <?php elseif ($req['mandatory']): ?>
                                <span class="badge badge-fail">Fail</span>
                            <?php else: ?>
                                <span class="badge badge-warn">Warn</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
