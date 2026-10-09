<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <div class="page-header">
        <h2>User List</h2>
        <a href="<?= base_url('users/new') ?>" class="primary-button">Add New User</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <?php $avatarPath = !empty($user['avatar']) ? base_url('uploads/avatars/' . $user['avatar']) : base_url('uploads/avatars/default-avatar.svg'); ?>
                    <tr>
                        <td><img src="<?= esc($avatarPath) ?>" alt="Profile avatar" class="thumbnail" /></td>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td>
                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="action-link">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->include('templates/footer') ?>