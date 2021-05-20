<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\SelectInfoInterface|Pollen\Filebrowser\Factory\DirInfoInterface|Pollen\Filebrowser\Factory\FileInfoInterface|null $selectinfo
 */

?>
<form method="post" data-filebrowser="rename">
    <?php if ($selectinfo) : ?>
    <div class="Filebrowser-formFields">
        <?php echo $this->field('hidden', ['name' => 'path', 'value' => $selectinfo->getRelPath()]); ?>

        <?php echo $this->field(
            'text',
            [
                'name'  => 'name',
                'value' => $selectinfo->getBasename($selectinfo->isFile() ? ".{$selectinfo->getExtension()}" : ''),
                'attrs' => [
                    'placeholder' => 'Saisissez le nouveau nom ...',
                ],
            ]
        ); ?>

        <?php if ($selectinfo->isFile()) : ?>
            <div class="Filebrowser-actionFormExt">
                <?php echo ".{$selectinfo->getExtension()}"; ?>
            </div>

            <?php echo $this->field(
                'checkbox',
                [
                    'after'   => $this->field(
                        'label',
                        [
                            'attrs'   => [
                                'for' => 'Filebrowser-actionFormRename--keep',
                            ],
                            'content' => 'Conserver l\'extension du fichier',
                        ]
                    ),
                    'attrs'   => [
                        'id'          => 'Filebrowser-actionFormRename--keep',
                        'style'       => 'display:inline-block',
                        'data-toggle' => '.Filebrowser-actionFormExt',
                    ],
                    'checked' => true,
                    'name'    => 'keep',
                    'value'   => 'on',
                ]
            ); ?>
        <?php else : ?>
            <?php echo $this->field(
                'hidden',
                [
                    'name'  => 'keep',
                    'value' => 'off',
                ]
            ); ?>
        <?php endif; ?>
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

        <?php echo $this->field(
            'button',
            [
                'attrs'   => [
                    'class'            => 'Filebrowser-button--cancel',
                    'data-filebrowser' => 'panel.toggle',
                    'data-target'      => '.Filebrowser-sidebarRename',
                    'data-reset'       => "[data-filebrowser='sidebar.rename']",
                ],
                'type'    => 'button',
                'content' => 'Annuler',
            ]
        ); ?>
    </div>
    <?php endif; ?>
</form>