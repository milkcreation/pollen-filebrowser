<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileCollectorInterface $files
 */
?>
<ul class="Filebrowser-contentFiles" data-control="filebrowser.content.items">
    <?php foreach ($files as $file) : ?>
        <li class="Filebrowser-contentFile" data-control="filebrowser.content.item">
            <?php $this->insert('file', compact('file')); ?>
        </li>
    <?php endforeach; ?>
</ul>