<?php

return [
    \App\Models\Admin::class      => '\/api\/admins(\?|\/|$)+',
    \App\Models\Setting::class    => '\/api\/settings(\?|\/|$)+',
    \App\Models\SeoMeta::class    => '\/api\/seo_metas(\?|\/|$)+',
    \App\Models\StaticPage::class => '\/api\/static_pages(\?|\/|$)+',
    \App\Models\Article::class    => '\/(id|en)\/api\/articles(\?|\/|$)+',
    \App\Models\Promo::class      => '\/(id|en)\/api\/promos(\?|\/|$)+',
    \App\Models\Location::class   => [
        '\/(id|en)\/api\/locations(\?|\/|$)+',
        '\/(id|en)\/api\/promos(\?|\/|$)+',
    ],
    \App\Models\Category::class => [
        '\/(id|en)\/api\/categories(\?|\/|$)+',
        '\/(id|en)\/api\/promos(\?|\/|$)+',
    ],
    \App\Models\Brand::class => [
        '\/(id|en)\/api\/brands(\?|\/|$)+',
        '\/(id|en)\/api\/promos(\?|\/|$)+',
    ],
    \App\Models\City::class => [
        '\/(id|en)\/api\/cities(\?|\/|$)+',
        '\/(id|en)\/api\/promos(\?|\/|$)+',
    ],
];
