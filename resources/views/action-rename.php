<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var tiFy\Template\Templates\FileManager\Contracts\FileInfo $file
 */
?>
<div class="Filebrowser-action Filebrowser-action--toggleable Filebrowser-action--rename"
     data-control="filebrowser.action.rename"
>
    <h3 class="Filebrowser-title"><?php _e('Renommer', 'tify'); ?></h3>

    <div class="Filebrowser-actionNotices"></div>

    <form class="Filebrowser-actionForm" method="post" action="" data-control="filebrowser.action.rename.form">
        <div class="Filebrowser-actionFormFields">
            <?php echo field('hidden', ['name' => 'path', 'value' => $file->getRelPath()]); ?>

            <div class="Filebrowser-actionFormField Filebrowser-actionFormField--name">
                <?php echo field('text', [
                    'name'  => 'name',
                    'value' => $file->getBasename($file->getExtension() ? ".{$file->getExtension()}" : ''),
                    'attrs' => [
                        'placeholder' => __('Saisissez le nouveau nom ...', 'tify')
                    ]
                ]); ?>
                <?php if ($file->getExtension()) : ?>
                    <div class="Filebrowser-actionFormExt">
                        <?php echo ".{$file->getExtension()}"; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($file->isFile()) : ?>
                <?php echo field('checkbox', [
                    'after'   => (string)field('label', [
                        'attrs'   => [
                            'for' => 'Filebrowser-actionFormRename--keep',
                        ],
                        'content' => 'Conserver l\'extension du fichier'
                    ]),
                    'attrs'   => [
                        'id'          => 'Filebrowser-actionFormRename--keep',
                        'style'       => 'display:inline-block',
                        'data-toggle' => '.Filebrowser-actionFormExt'
                    ],
                    'checked' => true,
                    'name'    => 'keep',
                    'value'   => 'on'
                ]); ?>
            <?php else : ?>
                <?php echo field('hidden', [
                    'name'  => 'keep',
                    'value' => 'off'
                ]); ?>
            <?php endif; ?>
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
                    'data-action'  => 'rename',
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
       data-action="rename">
        <?php echo $this->getIcon('close'); ?>
    </a>
</div>