<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POS Application') ?></title>
    <style>
        :root { --ink: #1f2937; --muted: #64748b; --brand: #0f766e; --brand-dark: #115e59; --line: #dbe5e3; --surface: #ffffff; --wash: #f0fdfa; }
        * { box-sizing: border-box; }
        body { background: #f7faf9; color: var(--ink); font-family: Arial, sans-serif; line-height: 1.6; margin: 0; }
        .site-shell { margin: 0 auto; max-width: 1120px; padding: 24px; }
        .site-header { align-items: center; display: flex; gap: 24px; justify-content: space-between; margin-bottom: 36px; }
        .brand { color: var(--brand-dark); font-size: 1.2rem; font-weight: 700; text-decoration: none; }
        nav { display: flex; flex-wrap: wrap; gap: 8px; }
        nav a { border-radius: 6px; color: var(--muted); padding: 8px 12px; text-decoration: none; }
        nav a:hover, nav a:focus { background: var(--wash); color: var(--brand-dark); }
        .page-heading { align-items: center; display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between; }
        .button { background: var(--brand); border-radius: 6px; color: #fff; display: inline-block; padding: 8px 14px; text-decoration: none; }
        .button:hover, .button:focus { background: var(--brand-dark); }
        .alert { border-radius: 6px; padding: 10px 14px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 700; margin-bottom: 6px; }
        input { border: 1px solid var(--line); border-radius: 5px; font: inherit; max-width: 520px; padding: 9px 10px; width: 100%; }
        .avatar { border-radius: 50%; height: 48px; object-fit: cover; width: 48px; }
        .table-avatar { border-radius: 50%; display: block; height: 48px; object-fit: cover; width: 48px; }
        main { background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: clamp(24px, 5vw, 56px); }
        h1 { color: var(--brand-dark); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.1; margin: 0 0 16px; }
        h2 { color: var(--brand-dark); margin-top: 0; }
        .lead { color: var(--muted); font-size: 1.15rem; max-width: 680px; }
        .page-heading { margin-bottom: 28px; }
        table { border-collapse: collapse; margin-top: 20px; min-width: 680px; width: 100%; }
        .table-wrap { overflow-x: auto; }
        th, td { border-bottom: 1px solid var(--line); padding: 14px 12px; text-align: left; }
        th { background: var(--wash); color: var(--brand-dark); font-size: .85rem; letter-spacing: .04em; text-transform: uppercase; }
        .page-header { align-items: center; display: flex; gap: 16px; justify-content: space-between; margin-bottom: 20px; }
        .primary-button, .button { background: var(--brand); border: 0; border-radius: 6px; color: #fff; display: inline-block; font-weight: 600; padding: 10px 18px; text-decoration: none; }
        .button-secondary { background: #e2e8f0; color: var(--ink); }
        .action-link { color: var(--brand-dark); font-weight: 600; text-decoration: none; }
        .row-action { border: 0; border-radius: 8px; display: inline-block; font: inherit; font-weight: 600; padding: 10px 16px; text-decoration: none; }
        .row-action-edit { background: var(--brand); color: #fff; }
        .row-action-delete { background: #c51e24; color: #fff; cursor: pointer; }
        .row-action-edit:hover, .row-action-edit:focus { background: var(--brand-dark); }
        .row-action-delete:hover, .row-action-delete:focus { background: #a9181d; }
        .admin-badge { background: var(--wash); border-radius: 999px; color: var(--brand-dark); display: inline-block; font-size: .8rem; font-weight: 700; margin-left: 8px; padding: 3px 10px; }
        .alert { border-radius: 6px; margin-bottom: 18px; padding: 12px 14px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input[type="text"], input[type="email"], input[type="file"] { border: 1px solid var(--line); border-radius: 6px; font: inherit; padding: 10px 12px; width: min(100%, 480px); }
        .form-actions { align-items: center; display: flex; gap: 12px; margin-top: 24px; }
        .current-avatar { align-items: center; background: #f8fafc; border: 1px solid var(--line); border-radius: 8px; display: flex; height: 180px; justify-content: center; margin: 8px 0; overflow: hidden; width: 180px; }
        .current-avatar .avatar { border-radius: 8px; height: 100%; object-fit: cover; width: 100%; }
        .thumbnail { align-items: center; background: #f8fafc; border: 1px solid var(--line); border-radius: 50%; display: inline-flex; height: 56px; justify-content: center; object-fit: cover; overflow: hidden; width: 56px; }
        footer { color: var(--muted); font-size: .9rem; padding: 20px 0; }
        @media (max-width: 640px) { .site-header { align-items: flex-start; flex-direction: column; gap: 12px; } .site-shell { padding: 16px; } .page-header { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>

<div class="site-shell">
    <header class="site-header">
        <a class="brand" href="<?= base_url('/') ?>">POS Workspace</a>
        <nav aria-label="Primary navigation">
            <a href="<?= base_url('/') ?>">Home</a>
            <a href="<?= base_url('about') ?>">About</a>
            <a href="<?= base_url('customers') ?>">Customers</a>
            <a href="<?= base_url('users') ?>">Users</a>
            <?php if (session()->get('isLoggedIn')): ?>
                <form action="<?= base_url('logout') ?>" method="post" style="display: inline;">
                    <?= csrf_field() ?>
                    <button class="button" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?= base_url('login') ?>">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>