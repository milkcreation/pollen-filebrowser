<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<div class="Filebrowser-browser">
    <ul class="Filebrowser-browserItems" data-control="filebrowser.browser.items">
        <li class="Filebrowser-browserItem Filebrowser-browserItem--dir" data-control="filebrowser.browser.item">
            <a href="#"
               class="Filebrowser-browserItemContent"
               data-path="<?php echo $this->getFile('/')->getRelPath(); ?>"
               data-control="filebrowser.browser.browse"
               aria-selected="true"
            >
                <?php echo $this->getIcon('collapse') . __('Racine', 'tify'); ?>
            </a>
            <?php if ($files = $this->getFiles()): ?>
                <?php $this->insert('browser-items', compact('files')); ?>
            <?php endif; ?>
        </li>
    </ul>
</div>
