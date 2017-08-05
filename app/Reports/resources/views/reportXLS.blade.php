<style>
    table {
        border-collapse: collapse;
        padding: 3px;
    }
    td.head {
        background-color: #395870;
        color: #fff;
        font-weight:bold;
        border: 2px solid black;
    }
</style>
<?php if (count($data) > 0): ?>
@if ($data['subGroup'] == true)
    <table>
        <tr style="outline: solid">
            <td class="head" align="center"><?php echo $data['groupByType']; ?></td>
            <td class="head" align="center"><?php echo $data['subGroupType']; ?></td>
            <td class="head" align="center">date</td>
            <td class="head" align="center">description</td>
            <td class="head" align="center">time</td>
        </tr>
        <?php foreach($data['groups'] as $subgroup): ?>
            <?php foreach($subgroup['subGroups'] as $item): ?>
                <?php foreach($item['entries'] as $entry): ?>
                    <tr>
                        <td><?php echo $subgroup['title']; ?></td>
                        <td><?php echo $item['title']; ?></td>
                        <td align="center"><?php echo $entry['date']; ?></td>
                        <td><?php echo $entry['description']; ?></td>
                        <td align="center"><?php echo $entry['time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
@else
    <table>
        <tr style="outline: solid">
            <td class="head" align="center"><?php echo $data['groupByType']; ?></td>
            <td class="head" align="center">date</td>
            <td class="head" align="center">description</td>
            <td class="head" align="center">time</td>
        </tr>
        <?php foreach($data['groups'] as $group): ?>
            <?php foreach($group['entries'] as $entry): ?>
                <tr>
                    <td><?php echo $group['title']; ?></td>
                    <td align="center"><?php echo $entry['date']; ?></td>
                    <td><?php echo $entry['description']; ?></td>
                    <td align="center"><?php echo $entry['time']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach ?>
    </table>
@endif
<?php endif; ?>
