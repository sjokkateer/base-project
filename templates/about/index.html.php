<?php
$additionalHeadTags = <<<HTML
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

        <link rel="stylesheet" href="../assets/css/about.css">
        <link rel="stylesheet" href="../assets/css/blog.css">
    HTML;
?>

<div id="left">
    <h1 class="blog-list-header">Who Am I?</h1>
    <div id="blog">
        <?php if ($intro != '') : ?>
            <?= $intro ?>
        <?php else : ?>
            Unknown
        <?php endif; ?>
    </div>
</div>

<div id="right">
    <h1 class="blog-list-header">Socials</h1>
    <div id="socials-content">
        <?php if ($socials != []) : ?>
            <?php include __DIR__ . '/socials.html.php' ?>
        <?php else : ?>
            No Socials Connected
        <?php endif; ?>
    </div>
</div>

<?php
$additionalJavaScript = <<<HTML
        <script>
            (() => {
                let firstParagraph = document.querySelector('p');
                
                if (firstParagraph !== null) {
                    firstParagraph.id = 'first-paragraph';
                }
            })();
        </script>
    HTML;
?>
