<?php
namespace KodiCMS\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \KodiCMS\Pages\Helpers\Meta
 */
class FrontpageMeta extends Facade
{

    /**
     * @return \KodiCMS\Pages\Helpers\Meta
     */
    public static function get()
    {
        return app('frontpage.meta');
    }


    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'frontpage.meta';
    }

}
