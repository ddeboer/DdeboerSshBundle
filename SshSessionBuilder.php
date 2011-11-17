<?php

namespace Ddeboer\SshBundle;

use Ssh\Session;
use Ssh\Configuration;
use Ssh\Authentication\HostBasedFile;
use Ssh\Authentication\Password;
use Ssh\Authentication\PublicKeyFile;



/**
 * Build an SSH session
 * 
 */
class SshSessionBuilder
{
    private $configuration;
    private $authentication;

    public function __construct($host, $port = 22)
    {
        $this->configuration = new Configuration($host, $port);
    }

    public function withPasswordAuthentication($username, $password)
    {
        $this->authentication = new Password($username, $password);
        return $this;
    }

    /**
     * Build
     *
     * @return Session
     */
    public function build()
    {
        return new Session($this->configuration, $this->authentication);
    }
}