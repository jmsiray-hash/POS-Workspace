<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <h2><?= esc($title ?? 'User Form') ?></h2>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $field => $message): ?>
                    <li><?= esc($field) ?>: <?= esc($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $mode === 'edit' ? site_url('users/update/' . ($user['id'] ?? 0)) : site_url('users/create') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= esc($user['username'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?= esc($user['full_name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="avatar">Profile Picture</label>
            <input type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
            <?php if (! empty($user['avatar'])): ?>
                <div class="current-avatar">
                    <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Current avatar" width="64" height="64">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit"><?= $mode === 'edit' ? 'Update User' : 'Save User' ?></button>
            <a href="<?= base_url('users') ?>" class="button button-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->include('templates/footer') ?>
