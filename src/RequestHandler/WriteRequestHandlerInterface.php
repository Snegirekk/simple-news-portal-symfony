<?php

namespace App\RequestHandler;

use App\Dto\AbstractDto;

interface WriteRequestHandlerInterface extends RequestHandlerInterface
{
    /**
     * @param AbstractDto $data
     * @return AbstractDto
     */
    public function write(AbstractDto $data): AbstractDto;

    /**
     * @param iterable $data
     * @return AbstractDto
     */
    public function writeBatch(iterable $data): AbstractDto;

    /**
     * @param AbstractDto $data
     */
    public function delete(AbstractDto $data): void;

    /**
     * @param iterable $data
     */
    public function deleteBatch(iterable $data): void;
}