<div class="page-heading">
    <h1>Customer Accounts</h1>
    <p class="lead">Review the customers currently associated with this workspace.</p>
</div>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers) && is_array($customers)): ?>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= esc($customer['id']) ?></td>
                    <td><?= esc($customer['name']) ?></td>
                    <td><?= esc($customer['email']) ?></td>
                    <td><?= esc($customer['phone']) ?></td>
                    <td><?= esc($customer['city']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No customers found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>