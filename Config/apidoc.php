<?php

return [
    /**
     * api document title
     */
    'title' => 'apidoc-title',

    /**
     * api document name
     */
    'name' => 'apidoc-name',

    /**
     * api document description, support html code
     */
    'description' => 'apidoc-description',

    /**
     * Need to provide api documentation directory
     */
    'dir' => 'App/Http/Controllers',

    /**
     * Directory to be excluded, relative to dir
     */
    'except_folders' => ['V3'],

    /**
     * Files to be excluded, relative to dir
     */
    'except_files' => ['Controller.php', 'V3/DemoController.php']
];
