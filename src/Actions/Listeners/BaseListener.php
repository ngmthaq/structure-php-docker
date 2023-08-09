<?php

namespace Src\Actions\Listeners;

abstract class BaseListener
{
    protected mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    abstract protected function handle(): void;
}
