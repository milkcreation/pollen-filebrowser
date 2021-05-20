<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileCollectorInterface $files
 * @var Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<ul class="Filebrowser-browserItems" data-control="filebrowser.browser.items">
    <?php foreach ($files as $file) : ?>
        <li class="Filebrowser-browserItem Filebrowser-browserItem--<?php echo $file->isDir() ? 'dir': 'file';?>"
            data-control="filebrowser.browser.item">
            <?php $this->insert('browser-item', compact('file')); ?>
        </li>
    <?php endforeach; ?>
</ul>