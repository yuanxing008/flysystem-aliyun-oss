<?php
namespace Zsimple\Flysystem\AliyunOss;

use Storage;
use OSS\OssClient;
use League\Flysystem\Filesystem;
use Illuminate\Support\ServiceProvider;

/**
 * Aliyun Oss ServiceProvider class.
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 */
class AliyunOssServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('oss', function ($app, $config) {
            $accessId = $config['access_key'];
            $accessKey = $config['secret_key'];
            $endPoint = $config['endpoint'];
            $bucket = $config['bucket'];
            $prefix = null;
            if (isset($config['prefix'])) {
                $prefix = $config['prefix'];
            }
            $client = new OssClient($accessId, $accessKey, $endPoint);
            $adapter = new AliyunOssAdapter($client, $bucket, $prefix, $config);
            $filesystem = new Filesystem($adapter);
            return $filesystem;
        });
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
