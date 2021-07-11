<?php
namespace ArunFung\Shop\Wap\Member\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wap-member:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这个是wap下的member组件安装命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // call
        $this->call('migrate');
        $this->call('vendor:publish', [
            // 参数表示 => 参数值
            "--provider"=>"ArunFung\Shop\Wap\Member\Providers\MemberServiceProvider"
        ]);
        // php artisan wap-member:install
        // php artisan migrate
        // php artisan seed:db
    }
}