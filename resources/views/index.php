<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */
?>
<div <?php echo $this->htmlAttrs(); ?>>
    <div class="Filebrowser-notifier" data-filebrowser="notifier">
        <?php $this->insert('notifier', $this->all()); ?>
    </div>

    <aside class="Filebrowser-sidebar" data-filebrowser="sidebar">
        <?php $this->insert('sidebar', $this->all()); ?>
    </aside>

    <?php //$this->insert('browser'); ?>

    <div class="Filebrowser-view" data-filebrowser="view" data-view="grid">
        <?php $this->insert('view', $this->all()); ?>
    </div>
</div>