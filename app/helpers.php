<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('crud_no_sanitise')) {
    /**
     * No Sanitise fields for xss (ex : rich text)
     * @return array
     */
    function crud_no_sanitise(): array
    {
        return [
            'excerpt',
            'description',
            'content',
        ];
    }
}
if (!function_exists('human_file_size')) {
    /**
     * Read file size
     *
     * @param string $bytes
     * @param int $decimals
     *
     * @return string
     */
    function human_file_size(string $bytes, int $decimals = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}


if (!function_exists('crud_route')) {
    /**
     * Basic CRUD routin (index/create/store/edit/update/delete)
     * @param string $uri
     * @param string $controller
     * @param string $name
     *
     * @return void
     */
    function crud_route(string $uri, string $controller, string $name): void
    {
        // List
        Route::get("/{$uri}", [$controller, 'index'])
            ->name($name . '.index');
        Route::get("/{$uri}/create", [$controller, 'create'])
            ->name($name . '.create');
        // Insert
        Route::post("/{$uri}/store", [$controller, 'store'])
            ->name($name . '.store');
        // Edit
        Route::get("/{$uri}/edit/{id}", [$controller, 'edit'])
            ->name($name . '.edit')
            ->where(['id' => '[a-z-0-9\-]+']);
        // Update
        Route::put("/{$uri}/update/{id}", [$controller, 'update'])
            ->name($name . '.update')
            ->where(['id' => '[a-z-0-9\-]+']);
        // Delete
        Route::get("/{$uri}/destroy/{id}", [$controller, 'destroy'])
            ->name($name . '.destroy')
            ->where(['id' => '[a-z-0-9\-]+']);
    }
}
if (!function_exists('render_content')) {
    /**
     * Sanitize content to render
     *
     * @param string|null $content
     * @param string $tags
     * @param mixed <br>
     * @param mixed <p>
     * @param mixed <span>
     * @param mixed <a>
     * @param mixed <h1>
     * @param mixed <h2>
     * @param mixed <h3>
     * @param mixed <h4>
     * @param mixed <h5>
     * @param mixed <h6>
     * @param mixed <b>
     * @param mixed <i>
     * @param mixed <strong>
     * @param mixed <table>
     * @param mixed <thead>
     * @param mixed <tbody>
     * @param mixed <tr>
     * @param mixed <td>
     * @param mixed <th>
     * @param mixed <ul>
     * @param mixed <ol>
     * @param mixed <li>'
     *
     * @return string
     */
    function render_content(?string $content = null, string $tags = '<img>,<br>,<p>,<span>,<a>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<b>,<i>,<strong>,<table>,<thead>,<tbody>,<tr>,<td>,<th>,<ul>,<ol>,<li>'): string
    {
        if (!$content) {
            return '';
        }

        return strip_tags($content, $tags);
    }
}
