<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<?php $this->insert('spinner'); ?>

<?php
echo partial('tag', [
    'tag'   => 'iframe',
    'attrs' => [
        'class'       => 'Filebrowser-preview Filebrowser-preview--document',
        'frameborder' => 0,
        'src'         => "//docs.google.com/viewer?embedded=true&hl=fr&url=" . $file->getUrl(true)
    ]
]);