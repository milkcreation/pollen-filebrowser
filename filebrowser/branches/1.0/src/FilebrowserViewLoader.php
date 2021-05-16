<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\View\FieldAwareViewLoader;
use Pollen\View\PartialAwareViewLoader;
use Pollen\View\ViewLoader;

/**
 * @method getIcon(string $name)
 */
class FilebrowserViewLoader extends ViewLoader implements FilebrowserViewLoaderInterface
{
    use FieldAwareViewLoader;
    use PartialAwareViewLoader;
}