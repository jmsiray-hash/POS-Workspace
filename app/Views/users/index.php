<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <div class="page-heading">
        <h2>Users</h2>
        <div style="align-items: flex-end; display: flex; flex-direction: column; gap: 8px;">
            <span><strong>Admin:</strong> <?= esc(session()->get('full_name')) ?></span>
            <a class="button" href="<?= base_url('users/new') ?>">Add User</a>
        </div>
    </div>
    <?php if (session()->getFlashdata('message')): ?>
        <p class="alert alert-success" role="status"><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>
    <div class="table-wrap">
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Avatar</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td>
                            <?= esc($user['full_name']) ?>
                            <?php if (! empty($user['is_admin'])): ?>
                                <span class="admin-badge">Admin</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($user['phone'] ?? '') ?></td>
                        <td>
                            <img
                                class="table-avatar"
                                src="<?= esc(base_url(! empty($user['avatar']) ? $user['avatar'] : 'images/default-avatar.svg')) ?>"
                                alt="<?= esc($user['full_name']) ?> avatar"
                                onerror="this.onerror=null;this.src='<?= esc(base_url('images/default-avatar.svg')) ?>';"
                            >
                        </td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td>
                            <a class="row-action row-action-edit" href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a>
                            <?php if (empty($user['is_admin'])): ?>
                                <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="post" style="display: inline;" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
                                    <?= csrf_field() ?>
                                    <button class="row-action row-action-delete" type="submit">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?= $this->include('templates/footer') ?>