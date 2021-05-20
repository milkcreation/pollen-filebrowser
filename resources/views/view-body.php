<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */
?>
<?php if ($files = $this->get('files')) : ?>
    <?php $this->insert('file-cards', $this->all()); ?>
<?php endif; ?>
