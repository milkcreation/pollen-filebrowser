<div class="Filebrowser-sidebarPathInfo Filebrowser-sidebarPanelWrapper">
    <div class="Filebrowser-sidebarPanel">
        <?php $this->insert('path-info', $this->all()); ?>
    </div>
</div>

<div class="Filebrowser-sidebarCreate Filebrowser-sidebarPanelWrapper">
    <div class="Filebrowser-sidebarPanel Filebrowser-sidebarPanel--toggleable">
        <h3 class="Filebrowser-sidebarPanelTitle"><?php echo 'Créer un dossier'; ?></h3>

        <?php $this->insert('path-create', $this->all()); ?>

        <button class="Filebrowser-sidebarPanelClose"
                data-filebrowser="panel.toggle"
                data-target=".Filebrowser-sidebarCreate"
                type="button"><?php echo $this->getIcon('close'); ?></button>
    </div>

    <button class="Filebrowser-button Filebrowser-sidebarOpenButton"
            data-filebrowser="panel.toggle"
            data-target=".Filebrowser-sidebarCreate"><?php echo 'Créer un dossier'; ?></button>
</div>

<div class="Filebrowser-sidebarUpload Filebrowser-sidebarPanelWrapper">
    <div class="Filebrowser-sidebarPanel Filebrowser-sidebarPanel--toggleable">
        <h3 class="Filebrowser-sidebarPanelTitle"><?php echo 'Ajouter des fichiers'; ?></h3>

        <?php $this->insert('path-upload', $this->all()); ?>

        <button class="Filebrowser-sidebarPanelClose"
                data-filebrowser="panel.toggle"
                data-target=".Filebrowser-sidebarUpload"
        ><?php echo $this->getIcon('close'); ?></button>
    </div>

    <button class="Filebrowser-button Filebrowser-sidebarOpenButton"
            data-filebrowser="panel.toggle"
            data-target=".Filebrowser-sidebarUpload"><?php echo 'Ajouter des fichiers'; ?></button>
</div>