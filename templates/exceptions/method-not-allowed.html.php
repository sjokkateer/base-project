<?php
$title = 'Method Not Allowed';
$message = sprintf(
    "%s is not allowed for %s",
    $request->getMethod(),
    $request->getUri()->getPath()
);
?>

<?php include __DIR__ . '/../layouts/exception.html.php' ?>
