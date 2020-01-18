<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(config('app.name'), URL::to('/'));
});

// //Home > Berita
// Breadcrumbs::for('berita.index', function ($trail) {
//     $trail->parent('home');
//     $trail->push('Berita', action('BeritaController@index'));
// });

// //Home > Berita > Create
// Breadcrumbs::for('berita.create', function ($trail) {
//     $trail->parent('berita.index');
//     $trail->push('Berita.create', action('BeritaController@create'));
// });
