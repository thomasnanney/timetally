<style>
    table {
        border-collapse: collapse;
        padding: 4px;
    }
    td.head{
        background-color: #395870;
        color: #fff;
        font-weight:bold;
        border-bottom: 2px solid black;
        font-size: 20px;
    }
    td.subhead{
        background-color: #75a3a3;
        color: #fff;
        font-weight:bold;
        border-bottom: 2px solid black;
        font-size: 17px;
    }
    td.detailTitle{
        background-color: #AAB7B8;
        color: #fff;
        font-weight:bold;
        border: 1px solid black
    }
    td.total{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
    }
    td.entry {
        text-align: center;
        border: 1px solid black
    }
</style>

<?php if (count($data) > 0): ?>
<table>
    @if ($data['subGroup'] == true)
        <tr>
            <td class="head"><?php echo $data['title']; ?></td>
            <td class="head"></td>
            <td class="head" align="center">Total Hours: <?php echo $data['totalTime']; ?></td>
        </tr>
        <?php foreach($data['groups'] as $subgroup): ?>
            <tr>
                <td class="subhead">    <?php echo $subgroup['title']; ?></td>
                <td class="subhead"></td>
                <td class="subhead"></td>
            </tr>
        <?php   foreach($subgroup['subGroups'] as $item): ?>
                    <tr>
                        <td class="detailTitle" align="center">   <?php echo $item['title']; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="entry">    Description:</td>
                        <td class="entry">    Time:</td>
                        <td></td>
                    </tr>
                    <?php   $description = array();
                            $time = array();
                            foreach($item['entries'] as $entry):
                                $description[] = $entry['description'];
                                $time[] = $entry['time'];
                            endforeach; ?>
                            <tr>
                                <td class="entry"><?php echo implode("<br>", $description); ?></td>
                                <td class="entry"><?php echo implode("<br>", $time); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="total">Total: <?php echo $item['totalTime']; ?></td>
                                <td></td>
                            </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
    @else
        <?php foreach($data['groups'] as $group): ?>
            <tr>
                <td class="head"><?php echo $group['title']; ?></td>
                <td class="head"></td>
                <td class="head" align="center">Total Hours: <?php echo $data['totalTime']; ?></td>
            </tr>
            <tr>
                <td class="entry">    Description:</td>
                <td class="entry">    Time:</td>
                <td></td>
            </tr>
            <?php
                $description = array();
                $time= array();
                foreach($group['entries'] as $entry):
                    $description[] = $entry['description'];
                    $time[] = $entry['time'];
                endforeach; ?>
                <tr>
                    <td class="entry"><?php echo implode("<br>", $description); ?></td>
                    <td class="entry"><?php echo implode("<br>", $time); ?></td>
                    <td></td>

                </tr>
                <tr>
                    <td></td>
                    <td class="total">Total: <?php echo $group['totalTime']; ?></td>
                    <td></td>
                </tr>
        <?php endforeach ?>
    @endif
</table>

<br><br>
<table>

</table>
<?php endif; ?>
