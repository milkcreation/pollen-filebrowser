<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\SelectInfoInterface|Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface|null $selectinfo
 */

?>
<div class="Filebrowser-selectedInfo" data-filebrowser="selectinfo">
    <?php if ($selectinfo) : ?>
        <div class="Filebrowser-infoIcon">
            <?php echo $selectinfo->getIcon(); ?>
        </div>

        <div class="Filebrowser-infos">
            <div class="Filebrowser-info Filebrowser-info--name">
                <label class="Filebrowser-infoLabel"><?php echo 'Nom :'; ?></label>
                <span class="Filebrowser-infoValue"><?php echo $selectinfo->getBasename(); ?></span>
            </div>

            <div class="Filebrowser-info Filebrowser-info--type">
                <label class="Filebrowser-infoLabel"><?php echo 'Type :'; ?></label>
                <span class="Filebrowser-infoValue"><?php echo $selectinfo->getHumanType(); ?></span>
            </div>

            <?php if ($selectinfo->isFile()) : ?>
                <div class="Filebrowser-info Filebrowser-info--ext">
                    <label class="Filebrowser-infoLabel"><?php echo 'Type de médias :'; ?></label>
                    <span class="Filebrowser-infoValue"><?php echo $selectinfo->getMimeType(); ?></span>
                </div>

                <div class="Filebrowser-info Filebrowser-info--size">
                    <label class="Filebrowser-infoLabel"><?php echo 'Taille :'; ?></label>
                    <span class="Filebrowser-infoValue"><?php echo $selectinfo->getHumanSize(); ?></span>
                </div>
            <?php endif; ?>

            <div class="Filebrowser-info Filebrowser-info--date">
                <label class="Filebrowser-infoLabel"><?php echo 'Date :'; ?></label>
                <span class="Filebrowser-infoValue">
                    <?php echo $selectinfo->getHumanDate('d/m/Y H:i:s'); ?>
                </span>
            </div>
        </div>

        <?php if ($selectinfo->isFile()) : ?>
            <div class="Filebrowser-infoHandlers">
                <a href="<?php echo  $selectinfo->getDownloadUrl(); ?>" class="Filebrowser-button--download">
                    <?php _e('Télécharger', 'tify'); ?>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>