<?php
namespace ArunFung\Shop\Wap\Member\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Overtrue\LaravelWeChat\Middleware\OAuthAuthenticate;

class MemberServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 注册组件路由
        $this->registerRoutes();

        // 注册中间件
        $this->registerRouteMiddleware();

        // 加载config配置文件
        $this->mergeConfigFrom(__DIR__.'/../Config/member.php', "wap.member");
    }

    public function boot()
    {
        // 加载配置
        $this->loadMemberAuthConfig();
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
    protected function loadMemberAuthConfig()
    {
        config(Arr::dot(config('wap.member.auth', []), 'auth.'));
    }
}
