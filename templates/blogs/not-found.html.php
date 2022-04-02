<?php
$title = 'Blog Not Found';
$message = sprintf("No blog found for '%s'", $error->slug());
?>

<?php include __DIR__ . '/../layouts/exception.html.php' ?>
