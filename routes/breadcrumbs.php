<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(config('app.name'), URL::to('/'));
});
