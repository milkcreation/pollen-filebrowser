<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface $file
 */

?>
<div data-filebrowser="file-card"
     data-path="<?php echo $file->getRelPath(); ?>"
     class="Filebrowser-fileCard Filebrowser-fileCard--<?php echo($file->isDir() ? 'dir' : 'file'); ?><?php echo $file->isSelected()? ' selected' : ''; ?>"
>
    <?php echo $file->getIcon(['class' => 'Filebrowser-viewFileIcon']); ?>

    <div class="Filebrowser-fileCardName">
        <?php echo $file->getBasename(); ?>
    </div>

    <?php if ($file->isFile()) : ?>
        <div class="Filebrowser-fileCardSize">
            <?php echo $file->getHumanSize(); ?>
        </div>
    <?php endif; ?>

    <div class="Filebrowser-fileCardMTime">
        <?php echo $file->getHumanDate('d/m/Y H:i'); ?>
    </div>
</div>