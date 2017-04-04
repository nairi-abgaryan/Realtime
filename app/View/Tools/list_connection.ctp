<style>
    table {
       font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    caption{
        padding:10px 5px 5px 5px;
        background: #D3EDF6;
    }
</style>
<table>
    <caption >Քանակը <?php  echo count($obj); ?> </caption>
    <thead>
    <tr>
        <td>Լոգին</td>
        <td>Սկիզբ</td>
        <td>Վերջ</td>
        <td>Օրերի քանակ</td>
        <td>Տեսնել ավելին</td>
    </tr>
    </thead>
    <tbody>
    <?php  foreach ($obj as $connection): ?>
        <tr>
            <td><?php echo $connection["tech"]["username"]; ?></td>
            <td><?php echo $connection["Person"]["created"]; ?></td>
            <td><?php echo $connection["Person"]["modified"]; ?></td>
            <td><?php
                $datetime1 = new DateTime($connection["Person"]["created"]);
                $datetime2 = new DateTime($connection["Person"]["modified"]);
                $interval = date_diff($datetime1, $datetime2);
                echo (int)$interval->format('%R%a'); ?>
            </td>
            <td><a target="_blank" href="/realtimes/search?se=<?php echo $connection['tech']['data_id']; ?>">...</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php die(); ?>
