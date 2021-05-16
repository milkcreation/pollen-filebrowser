<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<div class="Filebrowser-sidebarInfos" data-control="filebrowser.sidebar.file-infos">
    <h3 class="Filebrowser-title"><?php _e('Élèment sélectionné', 'tify'); ?></h3>
    <?php $this->insert('file-infos', compact('file')); ?>
</div>

<h3 class="Filebrowser-title"><?php _e('Répertoire courant', 'tify'); ?></h3>

<ul class="Filebrowser-sidebarActions">
    <li class="Filebrowser-sidebarAction Filebrowser-sidebarAction--create">

        <?php $this->insert('action-create', compact('file')); ?>

        <div class="Filebrowser-sidebarActionButton">
            <a href="#"
               class="Filebrowser-button Filebrowser-button--toggle"
               data-control="filebrowser.action.toggle"
               data-action="create"
            ><?php _e('Créer un dossier', 'tify'); ?></a>
        </div>
    </li>

    <li class="Filebrowser-sidebarAction Filebrowser-sidebarAction--upload">
        <?php $this->insert('action-upload', compact('file')); ?>
        <div class="Filebrowser-sidebarActionButton">
            <a href="#"
               class="Filebrowser-button Filebrowser-button--toggle"
               data-control="filebrowser.action.toggle"
               data-action="upload"
            ><?php _e('Ajouter des fichiers', 'tify'); ?></a>
        </div>
    </li>
</ul>
