<?= $this->include('templates/header') ?>

<section class="page-heading">
    <h1><?= esc($title) ?></h1>
</section>

<?php if (session()->getFlashdata('error')): ?><p class="alert error"><?= esc(session()->getFlashdata('error')) ?></p><?php endif; ?>
<?php if (isset($validation) && $validation->getErrors()): ?><div class="alert error"><?= $validation->listErrors() ?></div><?php endif; ?>

<form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" value="<?= old('full_name', $customer['full_name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= old('email', $customer['email'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input id="phone" name="phone" value="<?= old('phone', $customer['phone'] ?? '') ?>">
    </div>
    <button class="button" type="submit">Save Customer</button>
    <a href="<?= base_url('customers') ?>">Cancel</a>
</form>

<?= $this->include('templates/footer') ?>
