<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\SelectInfoInterface|Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface|null $selectinfo
 */

?>
<form method="post" data-filebrowser="delete">
    <?php if ($selectinfo) : ?>
    <div class="Filebrowser-formNotice">
        <?php if ($selectinfo->isDir()) : ?>
            <?php echo $this->partial(
                'notice',
                [
                    'attrs'   => [
                        'class' => '%s Filebrowser-notice Filebrowser-notice--warning',
                    ],
                    'content' => '<b>ATTENTION :</b> Vous vous apprêtez à supprimer un répertoire ainsi ' .
                        'que l\'ensemble des fichiers et dossiers qu\'il contient. ' .
                        'Ils ne pourront être récupérés. <br><b>Êtes vous sûr ?</b>',
                    'type'    => 'warning',
                ]
            );
            ?>
        <?php else: ?>
            <?php echo $this->partial(
                'notice',
                [
                    'attrs'   => [
                        'class' => '%s Filebrowser-noticeMessage Filebrowser-noticeMessage--warning',
                    ],
                    'content' => '<b>ATTENTION :</b> Vous vous apprêtez à supprimer un fichier. ' .
                        'Il ne pourra être récupéré. <br><b>Êtes vous sûr ?</b>',
                    'type'    => 'warning',
                ]
            );
            ?>
        <?php endif; ?>
    </div>

    <div class="Filebrowser-fomFields">
        <?php echo $this->field('hidden', ['name' => 'path', 'value' => $selectinfo->getRelPath()]); ?>
    </div>

    <div class="Filebrowser-formButtons">
        <?php echo $this->field(
            'button',
            [
                'attrs'   => [
                    'class' => 'Filebrowser-button--submit',
                ],
                'type'    => 'submit',
                'content' => 'Valider',
            ]
        ); ?>
    </div>
    <?php endif; ?>
</form>