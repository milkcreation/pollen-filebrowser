<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var tiFy\Template\Templates\FileManager\Contracts\FileInfo $file
 */
?>
<div class="Filebrowser-action Filebrowser-action--toggleable Filebrowser-action--create"
     data-control="filebrowser.action.create"
>
    <h3 class="Filebrowser-title"><?php _e('Créer un dossier', 'tify'); ?></h3>

    <div class="Filebrowser-actionNotices"></div>

    <form class="Filebrowser-actionForm" method="post" action="" data-control="filebrowser.action.create.form">
        <div class="Filebrowser-actionFormFields">
            <?php echo field('hidden', ['name'  => 'path', 'value' => $file->getRelPath()]); ?>

            <?php echo field('text', [
                'name'  => 'name',
                'attrs' => [
                    'placeholder' => __('Saisissez le nom du dossier ...', 'tify')
                ]
            ]); ?>
        </div>

        <div class="Filebrowser-actionFormButtons">
            <?php echo field('button', [
                'attrs'   => [
                    'class' => 'Filebrowser-button Filebrowser-button--valid Filebrowser-actionButton'
                ],
                'type'    => 'submit',
                'content' => __('Valider', 'tify')
            ]); ?>

            <?php echo field('button', [
                'attrs'   => [
                    'class'        => 'Filebrowser-button Filebrowser-button--cancel Filebrowser-actionButton',
                    'data-control' => 'filebrowser.action.toggle',
                    'data-action'  => 'create',
                    'data-reset'   => 'true'
                ],
                'type'    => 'button',
                'content' => __('Annuler', 'tify')
            ]); ?>
        </div>
    </form>

    <a href="#"
       class="Filebrowser-actionClose"
       data-control="filebrowser.action.toggle"
       data-action="create">
        <?php echo $this->getIcon('close'); ?>
    </a>
</div>