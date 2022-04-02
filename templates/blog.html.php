<?php
$additionalHeadTags = <<<HTML
        <link rel="stylesheet" href="../assets/css/styles/stackoverflow-light.min.css">
        <script src="../assets/js/highlight.min.js"></script>
        
        <link rel="stylesheet" href="../assets/css/blog.css">
    HTML;
?>

<div id="blog-content">
    <h1 id="blog-title"><?= $blog->title ?></h1>
    <div id="blog-published" style="padding-left: 0.5em;">
        <small><?= $blog->date ?? 'unknown date' ?> at <?= $blog->time ?? 'unknown time' ?></small>
    </div>
    <hr>
    <div id="blog">
        <?= $blog->content ?>
    </div>
    <hr style="margin-bottom: 2.5em;">
</div>

<?php
$additionalJavaScript = <<<HTML
        <script>hljs.highlightAll();</script>
        <script>
            (() => {
                let firstParagraph = document.querySelector('p');
                firstParagraph.id = 'first-paragraph';
            })();
        </script>
    HTML;
?>
