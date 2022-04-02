<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">

    <?= $additionalHeadTags ?? '' ?>

    <title><?= $title ?? 'Welcome' ?></title>
</head>
<body>
    <?php include_once __DIR__ . '/navbar.html.php' ?>
    <div id="content">
        <?= $content ?>
    </div>

    <?= $additionalJavaScript ?? '' ?>
</body>
</html>
