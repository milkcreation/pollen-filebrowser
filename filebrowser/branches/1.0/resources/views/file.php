<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<a href="<?php //echo $file->getUrl(); ?>"
   data-path="<?php echo $file->getRelPath(); ?>"
   data-control="filebrowser.action.fetch"
   class="Filebrowser-contentFileLink Filebrowser-contentFileLink--<?php echo($file->isDir() ? 'dir' : 'file'); ?>"
>
    <div class="Filebrowser-contentFileAttr Filebrowser-contentFileAttr--preview">
        <?php echo $file->getIcon(); ?>
    </div>

    <div class="Filebrowser-contentFileAttr Filebrowser-contentFileAttr--name">
        <?php echo $file->getBasename(); ?>
    </div>

    <?php if ($file->isFile()) : ?>
    <div class="Filebrowser-contentFileAttr Filebrowser-contentFileAttr--size">
        <?php echo $file->getHumanSize(); ?>
    </div>
    <?php endif; ?>

    <div class="Filebrowser-contentFileAttr Filebrowser-contentFileAttr--date">
        <?php echo $file->getHumanDate('d/m/Y H:i'); ?>
    </div>
</a>