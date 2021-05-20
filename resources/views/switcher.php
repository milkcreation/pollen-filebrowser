<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */

?>
<div class="Filebrowser-switcher" data-filebrowser="switcher">
    <button class="Filebrowser-switcherToggle Filebrowser-switcherToggle--grid"
            data-filebrowser="switcher.toggle"
            data-toggle="grid"
    ><?php echo $this->getIcon('grid', ['class' => 'Filebrowser-switcherToggleIcon']); ?></button>

    <button class="Filebrowser-switcherToggle Filebrowser-switcherToggle--list"
            data-filebrowser="switcher.toggle"
            data-toggle="list"
    ><?php echo $this->getIcon('list', ['class' => 'Filebrowser-switcherToggleIcon']); ?></button>
</div>