<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Controller;

use Pollen\Filebrowser\FilebrowserManagerInterface;
use Pollen\Filebrowser\FilebrowserProxy;
use Pollen\Routing\BaseController;
use Psr\Container\ContainerInterface as Container;

abstract class AbstractBaseController extends BaseController
{
    use FilebrowserProxy;

    /**
     * @param FilebrowserManagerInterface $filebrowserManager
     * @param Container|null $container
     */
    public function __construct(FilebrowserManagerInterface $filebrowserManager, ?Container $container = null)
    {
        $this->setFilebrowserManager($filebrowserManager);

        parent::__construct($container);
    }
}