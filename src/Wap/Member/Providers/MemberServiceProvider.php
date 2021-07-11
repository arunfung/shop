<?php
namespace ArunFung\Shop\Wap\Member\Providers;

use ArunFung\Shop\Wap\Member\Member;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Overtrue\LaravelWeChat\Middleware\OAuthAuthenticate;

class MemberServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('member', function ($app) {
            return new Member();
        });
        // 注册组件路由
        $this->registerRoutes();

        // 注册中间件
        $this->registerRouteMiddleware();

        // 加载config配置文件
        $this->mergeConfigFrom(__DIR__.'/../Config/member.php', "wap.member");

        $this->registerPublishing();
    }

    public function boot()
    {
        // 加载配置
        $this->loadMemberConfig();
        // 加载迁移文件
        $this->loadMigrations();

        $this->commands($this->commands);
    }

    // member组件需要注入的中间件
    protected $routeMiddleware = [
        'wechat.oauth' => OAuthAuthenticate::class,
    ];

    protected $middlewareGroups = [];

    // 加载中间件
    protected function registerRouteMiddleware()
    {
        foreach ($this->middlewareGroups as $key => $middleware) {
            $this->app['router']->middlewareGroup($key, $middleware);
        }

        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->app['router']->aliasMiddleware($key, $middleware);
        }
    }

    // 加载路由
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        });
    }

    private function registerPublishing()
    {
        $source = realpath(__DIR__.'/../config');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('wap')], 'laravel-shop-wap-member');
        }
    }

    // 加载路由配置
    private function routeConfiguration()
    {
        return [
            // 定义访问路由的域名
            // 'domain' => config('telescope.domain', null),
            // 是定义路由的命名空间
            'namespace' => 'ArunFung\Shop\Wap\Member\Http\Controllers',
            // 这是前缀
            'prefix' => 'wap/member',
            // 这是中间件
            'middleware' => 'web',
        ];
    }

    // 加载自定义配置
    protected function loadMemberConfig()
    {
        // 加载 member.wechat 配置到 wechat
        config(Arr::dot(config('wap.member.wechat', []), 'wechat.'));
        // 加载 member.auth 到 auth guard
        config(Arr::dot(config('wap.member.auth', []), 'auth.'));
    }

    protected $commands = [
        \ArunFung\Shop\Wap\Member\Console\Commands\InstallCommand::class
    ];

    public function loadMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        }
    }
}
