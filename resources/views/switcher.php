<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */
?>
<ul class="Filebrowser-switcher" data-control="filebrowser.switcher">
    <li class="Filebrowser-switch Filebrowser-switch--grid selected">
        <a href="#" class="Filebrowser-switchLink" data-control="filebrowser.view.toggle" data-view="grid">
            <?php echo $this->getIcon('grid'); ?>
        </a>
    </li>

    <li class="Filebrowser-switch Filebrowser-switch--list">
        <a href="#" class="Filebrowser-switchLink" data-control="filebrowser.view.toggle" data-view="list">
            <?php echo $this->getIcon('list'); ?>
        </a>
    </li>
</ul>