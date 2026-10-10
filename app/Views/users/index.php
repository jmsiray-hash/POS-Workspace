<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <div class="page-heading">
        <h2>User List</h2>
        <a class="button" href="<?= base_url('users/new') ?>">Add User</a>
    </div>
    <?php if (session()->getFlashdata('message')): ?><p class="alert success"><?= esc(session()->getFlashdata('message')) ?></p><?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?><p class="alert error"><?= esc(session()->getFlashdata('error')) ?></p><?php endif; ?>
    <div class="table-wrap">
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
                    <tr>
                        <td><img class="avatar" src="<?= $user['avatar'] ? base_url('uploads/avatars/' . $user['avatar']) : base_url('images/default-avatar.svg') ?>" alt="<?= esc($user['full_name']) ?> avatar"></td>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td><a href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?= $this->include('templates/footer') ?>