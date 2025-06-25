<?php
include 'blockchain.php';

session_start();

if (!isset($_SESSION['blockchain'])) {
    $blockchain = new Blockchain();
    $_SESSION['blockchain'] = serialize($blockchain);
} else {
    $blockchain = unserialize($_SESSION['blockchain']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['data'])) {
    $blockchain->addBlock($_POST['data']);
    $_SESSION['blockchain'] = serialize($blockchain);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Blockchain</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px;}
        th, td { border: 1px solid black; padding: 8px; text-align: left;}
        th { background-color: #f2f2f2;}
        input[type="text"] { width: 300px; padding: 5px;}
        input[type="submit"] { padding: 5px 10px;}
    </style>
</head>
<body>

<h2>PHP Blockchain Demo</h2>

<form method="POST">
    <label>Data for new block:</label>
    <input type="text" name="data" required>
    <input type="submit" value="Add Block">
</form>

<h3>Blockchain:</h3>
<table>
    <tr>
        <th>Index</th>
        <th>Timestamp</th>
        <th>Data</th>
        <th>Previous Hash</th>
        <th>Hash</th>
    </tr>
    <?php foreach ($blockchain->chain as $block): ?>
    <tr>
        <td><?php echo $block->index; ?></td>
        <td><?php echo $block->timestamp; ?></td>
        <td><?php echo $block->data; ?></td>
        <td><?php echo $block->previousHash; ?></td>
        <td><?php echo $block->hash; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
