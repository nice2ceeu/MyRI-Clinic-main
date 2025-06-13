<?php
$folder = "downloads/";

if (isset($_POST['delete'])) {
    $itemToDelete = $_POST['item'];

    $safePath = realpath($folder . basename($itemToDelete));

    if ($safePath && strpos($safePath, realpath($folder)) === 0) {
        if (is_file($safePath)) {
            unlink($safePath);
        } elseif (is_dir($safePath)) {
            rmdir($safePath);
        }
    }
}

$items = scandir($folder);

echo "<h3>Contents of $folder</h3>";

foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;

    $fullPath = $folder . $item;
    echo "<div>";

    if (is_dir($fullPath)) {
        echo "📁 <strong>$item</strong>";
    } else {
        echo "📄 $item";
    }

    echo "
        <form method='POST' style='display:inline'>
            <input type='hidden' name='item' value='$item'>
            <button type='submit' name='delete' onclick=\"return confirm('Delete $item?')\">🗑️ Delete</button>
        </form>
    </div>";
}
?><a href="studentlist.php">Form List</a>