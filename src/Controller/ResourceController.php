<?php

namespace Fullstackersio\Controller;

use Psr\Log\LoggerInterface;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\Responseinterface as Response;

class ResourceController
{
    private $table;
    private $logger;

    public function __construct(Builder $table, LoggerInterface $logger)
    {
        $this->table = $table;
        $this->logger = $logger;
    }

    public function list($request, $response, $args)
    {
        $resources = $this->table->get();

        return json_encode($resources);
    }
}