<?php
?>
<div class="Filebrowser-sidebarSelected Filebrowser-sidebarPanelWrapper">
    <?php $this->insert('selected-info', $this->all()); ?>
</div>

<div class="Filebrowser-sidebarRename Filebrowser-sidebarPanelWrapper">
    <div class="Filebrowser-sidebarPanel Filebrowser-sidebarPanel--toggleable">
        <h3 class="Filebrowser-sidebarPanelTitle"><?php echo 'Renommer'; ?></h3>

        <?php $this->insert('selected-rename', $this->all()); ?>

        <button class="Filebrowser-sidebarPanelClose"
                data-filebrowser="panel.toggle"
                data-target=".Filebrowser-sidebarRename"
                type="button"><?php echo $this->getIcon('close'); ?></button>
    </div>

    <button class="Filebrowser-button Filebrowser-sidebarOpenButton"
            data-filebrowser="panel.toggle"
            data-target=".Filebrowser-sidebarRename"><?php echo 'Renommer'; ?></button>
</div>

<div class="Filebrowser-sidebarDelete Filebrowser-sidebarPanelWrapper">
    <div class="Filebrowser-sidebarPanel Filebrowser-sidebarPanel--toggleable">
        <h3 class="Filebrowser-sidebarPanelTitle"><?php echo 'Supprimer'; ?></h3>

        <?php $this->insert('selected-delete', $this->all()); ?>

        <button class="Filebrowser-sidebarPanelClose"
                data-filebrowser="panel.toggle"
                data-target=".Filebrowser-sidebarDelete"
                type="button"><?php echo $this->getIcon('close'); ?></button>

    </div>
    <button class="Filebrowser-button Filebrowser-sidebarOpenButton"
            data-filebrowser="panel.toggle"
            data-target=".Filebrowser-sidebarDelete"><?php echo 'Supprimer'; ?></button>
</div>
