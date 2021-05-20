<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<?php if ($file->isDir()) : ?>
    <a href="#"
       class="Filebrowser-browserItemContent"
       data-path="<?php echo $file->getRelPath(); ?>"
       data-control="filebrowser.browser.browse"
    >
        <?php echo $this->getIcon('expand') . $file->getBasename(); ?>
    </a>
<?php else : ?>
    <span class="Filebrowser-browserItemContent">
    <?php echo $file->getBasename(); ?>
</span>
<?php endif; ?>