<?php

use  ArunFung\Shop\Wap\Member\Http\Controllers\AuthorizationsController;

Route::get("/wechat", [AuthorizationsController::class,"wechatStore"])->middleware("wechat.oauth");
