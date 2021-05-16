<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\Breadcrumb $breadcrumb
 */
?>
<ol class="Filebrowser-breadcrumb" data-control="filebrowser.breadcrumb">
    <?php foreach($breadcrumb as $path => $content) : ?>
        <li class="Filebrowser-breadcrumbPart">
            <a href="#"
               class="Filebrowser-breadcrumbPartLink"
               data-control="filebrowser.action.fetch"
               data-path="<?php echo $path; ?>"
            ><?php echo $content; ?></a>
        </li>
    <?php endforeach; ?>
</ol>