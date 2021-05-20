<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\PathInfo $pathinfo
 */
?>
<div class="Filebrowser-pathInfo" data-filebrowser="pathinfo">
        <div class="Filebrowser-infos">
            <div class="Filebrowser-info Filebrowser-info--path">
                <label class="Filebrowser-infoLabel"><?php echo 'Chemin :'; ?></label>
                <span class="Filebrowser-infoValue"><?php echo $pathinfo->dirname(); ?></span>
            </div>

            <div class="Filebrowser-info Filebrowser-info--date">
                <label class="Filebrowser-infoLabel"><?php echo 'Date :'; ?></label>
                <span class="Filebrowser-infoValue">
                    <?php echo $pathinfo->dirInfo()->getHumanDate('d/m/Y H:i:s'); ?>
                </span>
            </div>
        </div>
</div>
