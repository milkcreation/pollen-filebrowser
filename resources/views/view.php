<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */
?>
<header class="Filebrowser-viewHeader">
    <?php $this->insert('view-header', $this->all()); ?>
</header>

<main class="Filebrowser-viewBody">
    <?php $this->insert('view-body', $this->all()); ?>
</main>

<footer class="Filebrowser-viewFooter">
    <?php $this->insert('view-footer', $this->all()); ?>
</footer>
