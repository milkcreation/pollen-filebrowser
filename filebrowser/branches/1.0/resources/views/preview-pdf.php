<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var Pollen\Filebrowser\Factory\FileInfoInterface $file
 */
?>
<?php $this->insert('spinner'); ?>

<?php echo partial('pdfviewer', [
    'src'   => isset($file)
        ? $file->getUrl()
        : '7855ce7d975d5a1ede9b5a83d7235dee/document-manager/cache/Symfony_quick_tour_4.2.pdf',
    'attrs' => [
        'class' => 'Filebrowser-preview Filebrowser-preview--pdf'
    ],
    'prev'  => [
        'attrs'   => [
            'class' => '%s Filebrowser-button',
        ],
        'content' => $this->getIcon('prev')
    ],
    'next'  => [
        'attrs'   => [
            'class' => '%s Filebrowser-button',
        ],
        'content' => $this->getIcon('next')
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