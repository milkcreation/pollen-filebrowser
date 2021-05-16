<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

class IconCollection implements IconCollectionInterface
{
    use FilebrowserAwareTrait;

    /**
     * @var string[][]
     */
    protected $iconsMap = [
        'archive'    => 'regular.svg#file-archive',
        'audio'      => 'regular.svg#file-audio',
        'code'       => 'regular.svg#file-code',
        'close'      => 'solid.svg#times',
        'collapse'   => 'regular.svg#minus-square',
        'directory'  => 'solid.svg#folder',
        'download'   => 'solid.svg#download',
        'excel'      => 'regular.svg#file-excel',
        'expand'     => 'regular.svg#plus-square',
        'file'       => 'regular.svg#file',
        'fullscreen' => 'solid.svg#expand',
        'grid'       => 'solid.svg#th-large',
        'home'       => 'solid.svg#home',
        'image'      => 'regular.svg#file-image',
        'list'       => 'solid.svg#list-alt',
        'next'       => 'solid.svg#chevron-right',
        'pdf'        => 'regular.svg#file-pdf',
        'prev'       => 'solid.svg#chevron-left',
        'powerpoint' => 'regular.svg#file-powerpoint',
        'preview'    => 'regular.svg#eye',
        'spinner'    => 'solid.svg#spinner',
        'text'       => 'regular.svg#file-text',
        'video'      => 'regular.svg#file-video',
        'word'       => 'regular.svg#file-word',
        'upload'     => 'solid.svg#cloud-upload-alt',
    ];

    /**
     * @var string[][]
     */
    protected $mimesMap = [
        'application/pdf'                                                         => 'pdf',
        'application/msword'                                                      => 'word',
        'application/vnd.ms-word'                                                 => 'word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'word',
        'application/vnd.oasis.opendocument.text'                                 => 'word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml'          => 'word',
        'application/vnd.ms-excel'                                                => 'excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'       => 'excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml'             => 'excel',
        'application/vnd.oasis.opendocument.spreadsheet'                          => 'excel',
        'application/vnd.ms-powerpoint'                                           => 'powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml'            => 'powerpoint',
        'application/vnd.oasis.opendocument.presentation'                         => 'powerpoint',
        'text/plain'                                                              => 'text',
        'text/css'                                                                => 'code',
        'text/html'                                                               => 'code',
        'text/x-php'                                                              => 'code',
        'application/json'                                                        => 'code',
        'application/gzip'                                                        => 'archive',
        'application/zip'                                                         => 'archive',
        'image/jpeg'                                                              => 'image',
        'image/png'                                                               => 'image',
        'video/mp4'                                                               => 'video',
        'video/mpeg'                                                              => 'video',
        'video/ogg'                                                               => 'video',
        'video/webm'                                                              => 'video',
    ];

    /**
     * @inheritDoc
     */
    public function get(string $name): ?string
    {
        return $this->iconsMap[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function mimeTypeGet(string $mimeType): ?string
    {
        if ($name = $this->mimesMap[$mimeType] ?? null) {
            return $name;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function fileRender(FileInfoInterface $file): string
    {
        if (($mimeType = $file->getMimeType()) && ($name = $this->mimeTypeGet($mimeType))) {
            return $this->render($name);
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function render(string $name): string
    {
        if ($icon = $this->get($name)) {
            $url = $this->filebrowser()->manager()->getRouteUrl('sprites', ['sprite' => $icon]);

            return "<svg><use xlink:href=\"$url\"></use></svg>";
        }
        return '';
    }
}