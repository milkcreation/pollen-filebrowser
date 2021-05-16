<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var tiFy\Template\Templates\FileManager\Contracts\FileInfo $file
 */
?>
<div class="Filebrowser-action Filebrowser-action--toggleable Filebrowser-action--upload"
     data-control="filebrowser.action.upload"
>
    <h3 class="Filebrowser-title"><?php _e('Ajouter des fichiers', 'tify'); ?></h3>

    <div class="Filebrowser-actionNotices"></div>

    <div class="Filebrowser-actionContainer">
        <form action=""
              enctype="multipart/form-data"
              class="Filebrowser-actionForm Filebrowser-actionForm--upload"
              data-control="filebrowser.action.upload.form"
        >
            <div class="Filebrowser-actionFormFields">
                <?php echo field('hidden', ['name' => 'action', 'value' => 'upload']); ?>
                <?php echo field('hidden', ['name'  => 'path', 'value' => $file->getRelPath()]); ?>
            </div>
            <div class="Filebrowser-actionFormFallback fallback">
                <input name="file" type="file" multiple />
            </div>
        </form>
        <div class="Filebrowser-actionFormLegend">
            <?php echo $this->getIcon('upload') . __('Cliquez sur la zone ou glisser/déposer des fichiers', 'tify'); ?>
        </div>
    </div>

    <a href="#"
       class="Filebrowser-actionClose"
       data-control="filebrowser.action.toggle"
       data-action="upload">
        <?php echo $this->getIcon('close'); ?>
    </a>
</div>