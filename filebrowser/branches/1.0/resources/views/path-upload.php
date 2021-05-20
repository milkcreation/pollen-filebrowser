<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\PathInfoInterface $pathinfo
 */
?>
<form class="Filebrowser-form Filebrowser-uploader"
      enctype="multipart/form-data"
      method="post"
      data-filebrowser="upload"
>
    <div class="Filebrowser-sidebarPanelFormFields">
        <?php echo $this->field('hidden', ['name' => 'action', 'value' => 'uploadFile']); ?>
        <?php echo $this->field('hidden', ['name' => 'path', 'value' => $pathinfo->dirname()]); ?>
    </div>

    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>

    <div class="Filebrowser-uploaderHelper">
        <?php echo $this->getIcon(
            'upload',
            [
                'class' => 'Filebrowser-uploaderHelperIcon',
            ]
        ); ?>
        <span class="Filebrowser-uploaderHelperText">
            <?php echo 'Cliquez sur la zone ou glisser/déposer des fichiers'; ?>
        </span>
    </div>
</form>