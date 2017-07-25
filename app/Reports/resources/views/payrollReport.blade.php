<h1>Payroll Report for [Project Name here]</h1>

<?php if (count($shop) > 0): ?>
<table>
    <thead>
    <tr>
        <th><?php echo implode('</th><th>', array_keys(current($shop))); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($shop as $row): array_map('htmlentities', $row); ?>
    <tr>
        <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
