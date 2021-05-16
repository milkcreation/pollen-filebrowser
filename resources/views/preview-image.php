<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<?php $this->insert('spinner'); ?>
<?php echo partial('tag', [
    'tag'   => 'img',
    'attrs' => [
        'alt'   => $file->getBasename(),
        'class' => 'Filebrowser-preview Filebrowser-preview--image',
        'src'   => $file->getUrl()
    ]
]); ?>

<?php echo partial('tag', [
    'tag'     => 'a',
    'attrs'   => [
        'class'  => 'Filebrowser-button Filebrowser-button--fullscreen',
        'href'   => $file->getUrl(),
        'target' => '_blank'
    ],
    'content' => $this->getIcon('fullscreen')
]);