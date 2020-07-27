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
    'dir' => 'app/Http/Controllers',

    /**
     * Directory to be excluded, relative to dir, array type
     */
    'except_folders' => ['auth'],

    /**
     * Files to be excluded, relative to dir, array type
     */
    'except_files' => ['Controller.php', 'ExampleController.php'],

    /**
     * local translation
     */
    'local' => [
        'en' => [
            'header' => 'request header',
            'form' => 'form',
            'header-param' => 'request header parameters',
            'form-param' => 'form parameters',
            'field' => 'field',
            'type' => 'type',
            'description' => 'description',
            'optional' => 'optional',
            'send-examples-request' => 'send a sample request',
            'send-request' => 'send request',
            'return-result' => 'return result',
            'choose' => 'choose'
        ],
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
            'return-result' => '返回结果',
            'choose' => '选择'
        ]
    ]
];
