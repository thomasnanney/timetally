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
        font-size: 17px;
    }
    td.subhead {
        font-weight:bold;
        font-size: 14px;
    }
    td.total {
        border-top: 1px solid black;
        text-align: center;
        font-size: 12px;
    }
    td.entryLeft {
        text-align: left;
        font-size: 12px;
    }
    td.entryRight {
        text-align: right;
        font-size: 12px;
    }
    td.altEntryLeft {
        background-color:#e0ebeb;
        text-align: left;
        font-size: 12px;
    }
    td.altEntryRight {
        background-color:#e0ebeb;
        text-align: right;
        font-size: 12px;
    }
    .blank_row
    {
        height: 1px;
        line-height: 30%;
        background-color: #FFFFFF;
    }
</style>

<?php if (count($data) > 0): ?>
@if ($data['subGroup'] == true)
    <?php foreach($data['groups'] as $subgroup): ?>
        <table>
            <tr style="outline: solid">
                <td class="head" align="left" colspan="12"><?php echo $subgroup['title']; ?></td>
                <td class="head" align="center" colspan="3">Total: <?php echo $subgroup['totalTime']; ?></td>
            </tr>
            <?php foreach($subgroup['subGroups'] as $item): ?>
                <tr>
                    <td></td>
                    <td class="subhead" align="left" colspan="14"><?php echo $item['title']; ?></td>
                </tr>
                <?php $i = 1;
                foreach($item['entries'] as $entry):
                    if($i % 2 != 0): ?>
                        <tr>
                            <td colspan="2"></td>
                            <td class="entryLeft" colspan="2"><?php echo $entry['date']; ?></td>
                            <td class="entryLeft" colspan="10"><?php echo $entry['description']; ?></td>
                            <td class="entryRight"><?php echo $entry['time']; ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="2"></td>
                            <td class="altEntryLeft" colspan="2"><?php echo $entry['date']; ?></td>
                            <td class="altEntryLeft" colspan="10"><?php echo $entry['description']; ?></td>
                            <td class="altEntryRight"><?php echo $entry['time']; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php $i++; endforeach; ?>
                <tr>
                    <td colspan="12"></td>
                    <td class="total" colspan="3" align="right">Sub-Total: <?php echo $item['totalTime']; ?></td>
                </tr>
                <tr class="blank_row">
                    <td colspan="15"></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
@else
    <?php foreach($data['groups'] as $group): ?>
        <table>
            <tr>
                <td class="head" colspan="12"><?php echo $group['title']; ?></td>
                <td class="head" align="center" colspan="3">Total: <?php echo $group['totalTime']; ?></td>
            </tr>
            <?php $i = 1;
            foreach($group['entries'] as $entry):
                if($i % 2 != 0): ?>
                    <tr>
                        <td></td>
                        <td class="entryLeft" colspan="2"><?php echo $entry['date']; ?></td>
                        <td class="entryLeft" colspan="11"><?php echo $entry['description']; ?></td>
                        <td class="entryRight"><?php echo $entry['time']; ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td></td>
                        <td class="altEntryLeft" colspan="2"><?php echo $entry['date']; ?></td>
                        <td class="altEntryLeft" colspan="11"><?php echo $entry['description']; ?></td>
                        <td class="altEntryRight"><?php echo $entry['time']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php $i++; endforeach; ?>
            <tr class="blank_row">
                <td colspan="15"></td>
            </tr>
        </table>
    <?php endforeach ?>
@endif

<table>
    <tr>
        <td colspan="9"></td>
        <td class="head" align="center" colspan="4">Report Total:</td>
        <td class="head" align="center" colspan="2"><?php echo $data['totalTime']; ?></td>
    </tr>
</table>

<?php endif; ?>
