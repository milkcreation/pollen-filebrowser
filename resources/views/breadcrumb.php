<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\Breadcrumb $breadcrumb
 */
?>
<div class="Filebrowser-breadcrumb" data-filebrowser="breadcrumb">
    <?php foreach ($breadcrumb as $path => $content) : ?>
        <div class="Filebrowser-breadcrumbPart">
            <button class="Filebrowser-breadcrumbLink"
                    data-filebrowser="breadcrumb.link"
                    data-path="<?php echo $path; ?>"><?php echo $content; ?></button>
        </div>
    <?php endforeach; ?>
</div>