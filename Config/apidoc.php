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
    'except_files' => ['Controller.php', 'V3/DemoController.php'],

    /**
     * view file
     */
    'view' => '',

    /**
     * local language
     */
    'lang' => '',

    /**
     * local translation
     */
    'local' => [
        'zh-CN' => [
            'header' => '请求头',
            'form' => '表单',
            'header-param' => '请求头参数',
            'form-param' => '表单参数',
            'field' => '字段',
            'type' => '类型',
            'description' => '描述',
            'optional' => '可选',
            'send-examples-request' => '发送示例请求',
            'send-request' => '发送请求',
            'return-result' => '返回结果'
        ]
    ]
];
