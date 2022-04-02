<table style="width: 100%;">
    <?php if (is_array($socials)) : ?>
        <tbody>
            <?php foreach ($socials as $socialMedia) : ?>
                <tr>
                    <td class="icon-td"><i class="fab <?= $socialMedia->getIcon(); ?>"></i></td>
                    <td><a href="<?= $socialMedia->getUrl(); ?>" target="_blank"><?= $socialMedia->getDisplayText(); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
