<?php

return [

    'items' => [
        [
            'title'      => 'Dashboard',
            'url'        => '/cms',
            'icon'       => 'menu-icon fa fa-home',
            'permission' => 'access-cms',
            'children'   => [],
        ],
        [
            'title'      => 'Core',
            'url'        => 'javascript:void(0);',
            'icon'       => 'menu-icon fa fa-cogs',
            'permission' => 'access-cms',
            'children'   => [
                [
                    'title'      => 'Admins',
                    'url'        => '/cms/admins',
                    'icon'       => 'menu-icon fa fa-user',
                    'permission' => 'cms.admins.view',
                ],
                [
                    'title'      => 'Roles',
                    'url'        => '/cms/roles',
                    'icon'       => 'menu-icon fa fa-users',
                    'permission' => 'cms.roles.view',
                ],
                [
                    'title'      => 'SEO Metas',
                    'url'        => '/cms/seo_metas',
                    'icon'       => 'menu-icon fa fa-robot',
                    'permission' => 'cms.seo_metas.view',
                ],
                [
                    'title'      => 'Settings',
                    'url'        => '/cms/settings',
                    'icon'       => 'menu-icon fa fa-cog',
                    'permission' => 'cms.settings.view',
                ],
            ],
        ],
        [
            'title'      => 'Website',
            'url'        => 'javascript:void(0);',
            'icon'       => 'menu-icon fa fa-globe',
            'permission' => 'access-cms',
            'children'   => [
                [
                    'title'      => 'Static Pages',
                    'url'        => '/cms/static_pages',
                    'icon'       => 'menu-icon fa fa-file',
                    'permission' => 'cms.static_pages.view',
                ],
                [
                    'title'      => 'Privacy Policy',
                    'url'        => '/cms/privacy_policies',
                    'icon'       => 'menu-icon fa fa-shield-alt',
                    'permission' => 'cms.privacy_policies.view',
                ],
                [
                    'title'      => 'Departments',
                    'url'        => '/cms/departments',
                    'icon'       => 'menu-icon fa fa-building',
                    'permission' => 'cms.departments.view',
                ],
                [
                    'title'      => 'Schedules',
                    'url'        => '/cms/schedules',
                    'icon'       => 'menu-icon fa fa-calendar-alt',
                    'permission' => 'cms.schedules.view',
                ],
                [
                    'title'      => 'Subjects',
                    'url'        => '/cms/subjects',
                    'icon'       => 'menu-icon fa fa-book',
                    'permission' => 'cms.subjects.view',
                ],
                [
                    'title'      => 'Subject Schedules',
                    'url'        => '/cms/subject_schedules',
                    'icon'       => 'menu-icon fa fa-clock',
                    'permission' => 'cms.subject_schedules.view',
                ],
                [
                    'title'      => 'Buildings',
                    'url'        => '/cms/buildings',
                    'icon'       => 'menu-icon fa fa-building',
                    'permission' => 'cms.buildings.view',
                ],
                [
                    'title'      => 'Classrooms',
                    'url'        => '/cms/classrooms',
                    'icon'       => 'menu-icon fa fa-door-open',
                    'permission' => 'cms.classrooms.view',
                ],
            ],
        ],
    ],
];
