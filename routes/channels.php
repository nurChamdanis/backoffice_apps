<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chart', function ($user) {
    return [
        'name' => $user->name,
    ];
});
