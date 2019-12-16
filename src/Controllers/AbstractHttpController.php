<?php

namespace Jc9\PhpLibHttpLayer\Controllers;

use Illuminate\Routing\Controller;
use Psr\Log\LoggerInterface;

abstract class AbstractHttpController extends Controller
{
    protected $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }
}
