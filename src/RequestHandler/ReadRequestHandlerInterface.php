<?php

namespace App\RequestHandler;

use App\Dto\AbstractDto;
use App\Dto\PageDto;

interface ReadRequestHandlerInterface extends RequestHandlerInterface
{
    /**
     * @return AbstractDto
     */
    public function read(): AbstractDto;

    /**
     * @return PageDto
     */
    public function readPage(): PageDto;
}