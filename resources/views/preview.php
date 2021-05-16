<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
echo $this->partial('tag', [
    'tag'     => 'span',
    'attrs'   => [
        'class' => 'Filebrowser-preview Filebrowser-preview--default'
    ],
    'content' => $file->getIcon()
]);