<?php

namespace Pucoder\Apidoc\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

class ApiDocCommand extends Command
{
    /**
     * 文件系统
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * 要发布的提供者
     *
     * @var string
     */
    protected $provider = "Pucoder\Apidoc\ApiDocServiceProvider";

    /**
     * 控制台命令
     *
     * @var string
     */
    protected $signature = 'apidoc:publish {--force : Overwrite any existing files}';

    /**
     * 控制台命令说明
     *
     * @var string
     */
    protected $description = 'Publish any publishable assets from vendor packages';

    /**
     * 创建一个新的命令实例
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * 执行控制台命令
     *
     * @return void
     */
    public function handle()
    {
        $published = false;

        foreach ($this->pathsToPublish() as $from => $to) {
            $this->publishItem($from, $to);

            $published = true;
        }

        if ($published === false) {
            $this->error('Unable to locate publishable resources.');
        }

        $this->info('Publishing complete');
    }

    /**
     * 获取所有要发布的路径
     *
     * @return array
     */
    protected function pathsToPublish()
    {
        return ServiceProvider::pathsToPublish($this->provider);
    }

    /**
     * 从给定位置发布给定项目
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishItem($from, $to)
    {
        if ($this->files->isFile($from)) {
            return $this->publishFile($from, $to);
        } elseif ($this->files->isDirectory($from)) {
            return $this->publishDirectory($from, $to);
        }

        $this->error("Can't locate path: <{$from}>");
    }

    /**
     * 将文件发布到给定的路径
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishFile($from, $to)
    {
        if (!$this->files->exists($to) || $this->option('force')) {
            $this->createParentDirectory(dirname($to));

            $this->files->copy($from, $to);

            $this->status($from, $to, 'File');
        }
    }

    /**
     * 将目录发布到给定目录
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishDirectory($from, $to)
    {
        $this->moveManagedFiles(new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]));

        $this->status($from, $to, 'Directory');
    }

    /**
     * 在给定的挂载管理器中移动所有文件
     *
     * @param  \League\Flysystem\MountManager  $manager
     * @return void
     */
    protected function moveManagedFiles($manager)
    {
        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (! $manager->has('to://'.$file['path']) || $this->option('force'))) {
                $manager->put('to://'.$file['path'], $manager->read('from://'.$file['path']));
            }
        }
    }

    /**
     * 如果需要，创建目录来容纳发布的文件
     *
     * @param  string  $directory
     * @return void
     */
    protected function createParentDirectory($directory)
    {
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * 将状态消息写入控制台
     *
     * @param  string  $from
     * @param  string  $to
     * @param  string  $type
     * @return void
     */
    protected function status($from, $to, $type)
    {
        $from = str_replace(base_path(), '', realpath($from));

        $to = str_replace(base_path(), '', realpath($to));

        $this->line('<info>Copied '.$type.'</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }
}
