<?php

declare(strict_types=1);

namespace Illuminate\Mail;

if (class_exists('Illuminate\Mail\Mailable')) {
    return;
}

class Mailable {}
