<?php

namespace Core\Middleware;

class Guest
{
    public function handle()
    {
        if ($_SESSION['user'] ?? null) {
            header('Location: /');
            exit();
        }
    }
}
