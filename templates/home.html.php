<h1 class="blog-list-header">Most Recent Posts</h1>
<ul class="blog-list">
    <?php if ($blogs != []) : ?>
        <?php foreach ($blogs as $blog) : ?>
            <li>
                <h2 class="blog-list-title">
                    <a href="blogs/<?= $blog->slug ?>">
                        <?= $blog->title ?>
                    </a>
                </h2>
            </li>
        <?php endforeach; ?>
    <?php else : ?>
        None
    <?php endif; ?>
</ul>
