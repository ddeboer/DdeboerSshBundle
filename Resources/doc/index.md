SSH Bundle
==========

Introduction
------------
A small Symfony2 bundle for integrating Antoine Hérault’s PHP-SSH library into your 
Symfony2 project.

Requirements
------------

You need to install Antoine Hérault’s [PHP-SSH wrapper](https://github.com/Herzult/php-ssh) first. 

Installation
------------

Install this bundle like you would any other Symfony2 bundle. (Installation will 
soon be migrated to using Composer.)

Usage
-----

In your `config.yml`:

```
ddeboer_ssh:
  connections:
    an_sftp_server:
      host: hostname.com
      authentication_password:
        username: my_username
        password: my_password
```

In your application code:

```
$session = $this->getSession();
$sftp = $session->getSftp();
$sftp->write('/home/my_username/just_a_file.txt', 'some file contents');
```

For more information, please refer to the [PHP-SSH documentation](https://github.com/Herzult/php-ssh).