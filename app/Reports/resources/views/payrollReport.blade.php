<style>
    table {
        cellpadding: "20";
    }
    td.head{
        background-color: #395870;
        color: #fff;
    }
</style>
<h1>Payroll Report for [Project Name here]</h1>

<?php if (count($data) > 0): ?>
<table>
    <?php foreach($data as $group): ?>
        <thead>
            <tr>
                <td class="head"><?php echo $group['title']; ?></td>
                <td class="head"></td>
                <td class="head"></td>
            </tr>
        <?php   $projectid = array();
                $userid = array();
                $usertime = array();
                foreach($group['entries'] as $entry):
                    $projectid[] = $entry['projectid'];
                    $userid[] = $entry['userid'];
                    $usertime[] = $entry['userTime'];
                endforeach; ?>
                <tr>
                    <td>    Project ID: <?php echo implode("<br>    Project ID: ", $projectid); ?></td>
                    <td>    User ID: <?php echo implode("<br>    User ID: ", $userid); ?></td>
                    <td>    User Time: <?php echo implode("<br>    User Time: ", $usertime); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total Hours: <?php echo $group['totalTime']; ?></td>
                </tr>
        </thead>
    <?php endforeach; ?>
</table>

<br><br>
<table>

</table>
<?php endif; ?>
