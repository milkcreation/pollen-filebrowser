<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\View\FieldAwareViewLoaderInterface;
use Pollen\View\PartialAwareViewLoaderInterface;
use Pollen\View\ViewLoaderInterface;

interface FilebrowserViewLoaderInterface extends
    FieldAwareViewLoaderInterface,
    PartialAwareViewLoaderInterface,
    ViewLoaderInterface
{
}