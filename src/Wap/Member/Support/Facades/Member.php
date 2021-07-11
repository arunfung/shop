<?php
namespace ArunFung\Shop\Wap\Member\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Member
 * @method static \Illuminate\Contracts\Auth\Guard guard()
 *
 * @see \ArunFung\Shop\Wap\Member\Support
 * @package ArunFung\Shop\Wap\Member\Support\Facades
 */
class Member extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'member';
    }
}