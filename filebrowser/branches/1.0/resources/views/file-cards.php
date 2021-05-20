<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileCollectorInterface $files
 */
?>
<div class="Filebrowser-fileCards" data-filebrowser="file-cards">
    <?php foreach ($files as $file) : ?>
        <?php $this->insert('file-card', compact('file')); ?>
    <?php endforeach; ?>
</div>
