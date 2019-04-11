<?php

namespace App\Actions;

class AddProjectAction
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $clientId;

    public function __construct(string $name, int $clientId)
    {
        $this->name = $name;
        $this->clientId = $clientId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }
}
