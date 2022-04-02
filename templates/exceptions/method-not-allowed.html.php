<?php
$title = 'Method Not Allowed';
$message = "{$request->getMethod()} is not allowed for {$request->getUri()->getPath()}";
?>

<?php include __DIR__ . '/../layouts/exception.html.php' ?>
