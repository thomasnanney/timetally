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
        font-size: 20px;
    }
    td.subhead {
        background-color: #75a3a3;
        color: #fff;
        font-weight:bold;
        border: 1px solid black;
        font-size: 17px;
    }
    td.total {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
    }
    td.entryTitle {
        text-align: center;
        background-color: #90a1a2;
        color: #fff;
        font-weight:bold;
        border: 1px solid black;
    }

    td.entryLeft {
        text-align: left;
        border: 1px solid black;
    }
    td.entryCenter {
        text-align: center;
        border: 1px solid black;
    }
    .blank_row
    {
        height: 1px; /* overwrites any other rules */
        line-height: 30%;
        background-color: #FFFFFF;
    }
</style>

<?php if (count($data) > 0): ?>
{{--<table>--}}
    @if ($data['subGroup'] == true)
        <?php foreach($data['groups'] as $subgroup): ?>
            <table>
                <tr style="outline: solid">
                    <td class="head" align="center" colspan="2"><?php echo $subgroup['title']; ?></td>
                    <td class="head" align="center">Total Hours: <?php echo $subgroup['totalTime']; ?></td>
                </tr>
                <?php foreach($subgroup['subGroups'] as $item): ?>
                    <tr>
                        <td class="subhead" align="center" colspan="3"><?php echo $item['title']; ?></td>
                    </tr>
                    {{--<tr>
                        <td class="entryTitle" colspan="2">Description</td>
                        <td class="entryTitle">Hours</td>
                    </tr>--}}
                    <?php foreach($item['entries'] as $entry): ?>
                        <tr>
                            <td class="entryLeft" colspan="2"><?php echo $entry['description']; ?></td>
                            <td class="entryCenter"><?php echo $entry['time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2"></td>
                        <td class="total">Hours: <?php echo $item['totalTime']; ?></td>
                    </tr>
                    <tr class="blank_row">
                        <td colspan="3"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endforeach; ?>
    @else
        <?php foreach($data['groups'] as $group): ?>
            <tr>
                <td class="head" colspan="2"><?php echo $group['title']; ?></td>
                <td class="head" align="center">Total Hours: <?php echo $data['totalTime']; ?></td>
            </tr>
            <tr>
                <td class="entryTitle" colspan="2">Description</td>
                <td class="entryTitle">Hours</td>
            </tr>
            <?php
                foreach($group['entries'] as $entry): ?>
                    <tr>
                        <td class="entryLeft" colspan="2"><?php echo $entry['description']; ?></td>
                        <td class="entryCenter"><?php echo $entry['time']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"></td>
                    <td class="total">Total: <?php echo $group['totalTime']; ?></td>
                </tr>
                <tr class="blank_row">
                    <td colspan="3"></td>
                </tr>
        <?php endforeach ?>
    @endif
{{--</table>--}}

<br><br>
<table>

</table>
<?php endif; ?>
