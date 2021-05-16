<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<?php $this->insert('spinner'); ?>

<?php echo partial('tag', [
    'tag'     => 'video',
    'attrs'   => [
        'class'    => 'Filebrowser-preview Filebrowser-preview--video',
        'controls' => 'controls',
        'src'      => $file->getUrl()
    ],
    'content' => __('Votre navigateur de fichier n\'accepte pas ce type de fichier vidéo', 'tify')
]);