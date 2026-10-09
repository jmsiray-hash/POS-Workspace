<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <h2><?= esc($title ?? 'Customer Form') ?></h2>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $field => $message): ?>
                    <li><?= esc($field) ?>: <?= esc($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $mode === 'edit' ? site_url('customers/update/' . ($customer['id'] ?? 0)) : site_url('customers/create') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?= esc($customer['full_name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= esc($customer['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?= esc($customer['phone'] ?? '') ?>">
        </div>

        <div class="form-actions">
            <button type="submit"><?= $mode === 'edit' ? 'Update Customer' : 'Save Customer' ?></button>
            <a href="<?= base_url('customers') ?>" class="button button-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->include('templates/footer') ?>
