<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\SelectInfoInterface|null $selectinfo
 */
?>
<div class="Filebrowser-sidebarSelected<?php echo $selectinfo ?: ' hidden'; ?>" data-filebrowser="sidebar.selected">
    <h3 class="Filebrowser-sidebarTitle"><?php echo 'Sélection'; ?></h3>

    <?php $this->insert('sidebar-selected', $this->all()); ?>
</div>

<div class="Filebrowser-sidebarPath" data-filebrowser="sidebar.path">
    <h3 class="Filebrowser-sidebarTitle"><?php echo 'Répertoire'; ?></h3>

    <?php $this->insert('sidebar-path', $this->all()); ?>
</div>
