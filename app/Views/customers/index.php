<?= $this->include('templates/header') ?>

<div class="container mt-4">
    <div class="page-heading">
        <h2>Customers</h2>
        <a class="button" href="<?= base_url('customers/new') ?>">Add Customer</a>
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
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Avatar</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= esc($customer['full_name']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone']) ?></td>
                        <td>
                            <img
                                class="table-avatar"
                                src="<?= esc(base_url(! empty($customer['avatar']) ? $customer['avatar'] : 'images/default-avatar.svg')) ?>"
                                alt="<?= esc($customer['full_name']) ?> avatar"
                                onerror="this.onerror=null;this.src='<?= esc(base_url('images/default-avatar.svg')) ?>';"
                            >
                        </td>
                        <td><?= esc($customer['created_at']) ?></td>
                        <td>
                            <a class="row-action row-action-edit" href="<?= base_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a>
                            <form action="<?= base_url('customers/' . $customer['id'] . '/delete') ?>" method="post" style="display: inline;" onsubmit="return confirm('Delete this customer?');">
                                <?= csrf_field() ?>
                                <button class="row-action row-action-delete" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No customers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?= $this->include('templates/footer') ?>