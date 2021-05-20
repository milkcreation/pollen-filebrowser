<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\PathInfoInterface $pathinfo
 */

?>
<form method="post" data-filebrowser="create">
    <div class="Filebrowser-formFields">
        <?php echo $this->field('hidden', ['name' => 'path', 'value' => $pathinfo->dirname()]); ?>

        <?php echo $this->field(
            'text',
            [
                'name'  => 'name',
                'attrs' => [
                    'placeholder' => 'Saisir le nom du dossier ...',
                ],
            ]
        ); ?>
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
                    'data-reset'       => "[data-filebrowser='sidebar.create']",
                ],
                'type'    => 'button',
                'content' => 'Annuler',
            ]
        ); ?>
    </div>
</form>