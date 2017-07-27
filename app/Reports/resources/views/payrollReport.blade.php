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
    @if ($data['subGroup'] == 'true')
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
        <?php   foreach($subgroup['detail'] as $item): ?>
                    <tr>
                        <td class="detailTitle" align="center">   <?php echo $item['title']; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="entry">    Project ID:</td>
                        <td class="entry">    User ID:</td>
                        <td class="entry">    User Time:</td>
                    </tr>
                    <?php   $projectid = array();
                            $userid = array();
                            $usertime = array();
                            foreach($item['entries'] as $entry):
                                $projectid[] = $entry['projectid'];
                                $userid[] = $entry['userid'];
                                $usertime[] = $entry['userTime'];
                            endforeach; ?>
                            <tr>
                                <td class="entry"><?php echo implode("<br>", $projectid); ?></td>
                                <td class="entry"><?php echo implode("<br>", $userid); ?></td>
                                <td class="entry"><?php echo implode("<br>", $usertime); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="total">Total Hours: <?php echo $item['totalTime']; ?></td>
                            </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
    @else
        <?php foreach($data['groups'] as $group): ?>
            <tr>
                <td class="head"><?php echo $group['title']; ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="entry">    Project ID:</td>
                <td class="entry">    User ID:</td>
                <td class="entry">    User Time:</td>
            </tr>
            <?php $projectid = array();
                $userid = array();
                $usertime = array();
                foreach($group['entries'] as $entry):
                    $projectid[] = $entry['projectid'];
                    $userid[] = $entry['userid'];
                    $usertime[] = $entry['userTime'];
                endforeach; ?>
                <tr>
                    <td class="entry"><?php echo implode("<br>", $projectid); ?></td>
                    <td class="entry"><?php echo implode("<br>", $userid); ?></td>
                    <td class="entry"><?php echo implode("<br>", $usertime); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="total">Total Hours: <?php echo $group['totalTime']; ?></td>
                </tr>
        <?php endforeach ?>
    @endif
</table>

<br><br>
<table>

</table>
<?php endif; ?>
