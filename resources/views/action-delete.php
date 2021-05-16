<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var tiFy\Template\Templates\FileManager\Contracts\FileInfo $file
 */
?>
<div class="Filebrowser-action Filebrowser-action--toggleable Filebrowser-action--delete"
     data-control="filebrowser.action.delete"
>
    <h3 class="Filebrowser-title"><?php _e('Supprimer', 'tify'); ?></h3>

    <div class="Filebrowser-actionNotices">
        <?php if ($file->isDir()) : ?>
            <?php echo partial('notice', [
                'attrs' => [
                    'class' => 'Filebrowser-noticeMessage Filebrowser-noticeMessage--warning'
                ],
                'content' => __('<b>ATTENTION :</b> Vous vous apprêtez à supprimer un répertoire ainsi ' .
                    'que l\'ensemble des fichiers et dossiers qu\'il contient. ' .
                    'Ils ne pourront être récupérés. <br><b>Êtes vous sûr ?</b>', 'tify'),
                'type'    => 'warning'
            ]);
            ?>
        <?php else: ?>
            <?php echo partial('notice', [
                'attrs' => [
                    'class' => 'Filebrowser-noticeMessage Filebrowser-noticeMessage--warning'
                ],
                'content' => __('<b>ATTENTION :</b> Vous vous apprêtez à supprimer un fichier. '.
                    'Il ne pourra être récupéré. <br><b>Êtes vous sûr ?</b>', 'tify'),
                'type'    => 'warning',
            ]);
            ?>
        <?php endif; ?>
    </div>
    <form class="Filebrowser-actionForm" method="post" action="" data-control="filebrowser.action.delete.form">
        <div class="Filebrowser-actionFormFields">
            <?php echo field('hidden', ['name'  => 'path', 'value' => $file->getRelPath()]); ?>
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
                    'class' => 'Filebrowser-button Filebrowser-button--cancel Filebrowser-actionButton',
                    'data-control' => 'filebrowser.action.toggle',
                    'data-action'  => 'delete',
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
       data-action="delete">
        <?php echo $this->getIcon('close'); ?>
    </a>
</div>