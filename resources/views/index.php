<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 */

?>
<div <?php echo $this->htmlAttrs(); ?>>
    <?php $this->insert('notice'); ?>

    <aside class="Filebrowser-sidebar" data-control="filebrowser.sidebar">
        <?php //$this->insert('sidebar', ['file' => $this->getFile()]); ?>
    </aside>

    <?php //$this->insert('browser'); ?>

    <div class="Filebrowser-content" data-control="filebrowser.content" data-view="grid">
        <header class="Filebrowser-contentHeader">
            <?php $this->insert('breadcrumb', $this->all()); ?>
            <?php //$this->insert('switcher'); ?>
        </header>

        <main class="Filebrowser-contentBody">
            <?php if ($files = $this->get('files')) : ?>
                <?php $this->insert('files', compact('files')); ?>
            <?php endif; ?>
        </main>

        <footer class="Filebrowser-contentFooter"></footer>
    </div>
</div>