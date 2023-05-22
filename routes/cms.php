<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Home\Index')->name('home');
Route::get('/current-admin/profile', 'CurrentAdmin\Profile')->name('current-admin.profile');

/**
 * Begin route definition for `Settings` resources.
 */
Route::get('/settings', 'Settings\SettingsIndex')->name('settings.index');
Route::get('/settings/create', 'Settings\CreateSetting')->name('settings.create');
Route::get('/settings/{setting}', 'Settings\ShowSetting')->name('settings.show');
Route::get('/settings/{setting}/edit', 'Settings\EditSetting')->name('settings.edit');

/**
 * Begin route definition for `Roles` resources.
 */
Route::get('/roles', 'Roles\RolesIndex')->name('roles.index');
Route::get('/roles/create', 'Roles\CreateRole')->name('roles.create');
Route::get('/roles/{role}', 'Roles\ShowRole')->name('roles.show');
Route::get('/roles/{role}/edit', 'Roles\EditRole')->name('roles.edit');

/**
 * Begin route definition for `Admins` resources.
 */
Route::get('/admins', 'Admins\AdminsIndex')->name('admins.index');
Route::get('/admins/create', 'Admins\CreateAdmin')->name('admins.create');
Route::get('/admins/{admin}', 'Admins\ShowAdmin')->name('admins.show');
Route::get('/admins/{admin}/edit', 'Admins\EditAdmin')->name('admins.edit');

/**
 * Begin route definition for `Seo Metas` resources.
 */
Route::get('/seo_metas', 'SeoMetas\SeoMetasIndex')->name('seo_metas.index');
Route::get('/seo_metas/create', 'SeoMetas\CreateSeoMeta')->name('seo_metas.create');
Route::get('/seo_metas/{seoMeta}', 'SeoMetas\ShowSeoMeta')->name('seo_metas.show');
Route::get('/seo_metas/{seoMeta}/edit', 'SeoMetas\EditSeoMeta')->name('seo_metas.edit');

/**
 * Begin route definition for `Static Pages` resources.
 */
Route::get('/static_pages', 'StaticPages\StaticPagesIndex')->name('static_pages.index');
Route::get('/static_pages/create', 'StaticPages\CreateStaticPage')->name('static_pages.create');
Route::get('/static_pages/{staticPageId}', 'StaticPages\ShowStaticPage')->name('static_pages.show');
Route::get('/static_pages/{staticPageId}/edit', 'StaticPages\EditStaticPage')->name('static_pages.edit');

/**
 * Begin route definition for `Privacy Policies` resources.
 */
Route::get('/privacy_policies', 'PrivacyPolicies\PrivacyPoliciesIndex')->name('privacy_policies.index');
Route::get('/privacy_policies/create', 'PrivacyPolicies\CreatePrivacyPolicy')->name('privacy_policies.create');
Route::get('/privacy_policies/{privacyPolicyId}', 'PrivacyPolicies\ShowPrivacyPolicy')->name('privacy_policies.show');
Route::get('/privacy_policies/{privacyPolicyId}/edit', 'PrivacyPolicies\EditPrivacyPolicy')->name('privacy_policies.edit');

/**
 * Begin route definition for `Departments` resources.
 */
Route::get('/departments', 'Departments\DepartmentsIndex')->name('departments.index');
Route::get('/departments/create', 'Departments\CreateDepartment')->name('departments.create');
Route::get('/departments/{department}', 'Departments\ShowDepartment')->name('departments.show');
Route::get('/departments/{department}/edit', 'Departments\EditDepartment')->name('departments.edit');


/**
 * Begin route definition for `Schedules` resources.
 */
Route::get('/schedules', 'Schedules\SchedulesIndex')->name('schedules.index');
Route::get('/schedules/create', 'Schedules\CreateSchedule')->name('schedules.create');
Route::get('/schedules/{schedule}', 'Schedules\ShowSchedule')->name('schedules.show');
Route::get('/schedules/{schedule}/edit', 'Schedules\EditSchedule')->name('schedules.edit');


/**
 * Begin route definition for `Subjects` resources.
 */
Route::get('/subjects', 'Subjects\SubjectsIndex')->name('subjects.index');
Route::get('/subjects/create', 'Subjects\CreateSubject')->name('subjects.create');
Route::get('/subjects/{subject}', 'Subjects\ShowSubject')->name('subjects.show');
Route::get('/subjects/{subject}/edit', 'Subjects\EditSubject')->name('subjects.edit');


/**
 * Begin route definition for `Subject Schedules` resources.
 */
Route::get('/subject_schedules', 'SubjectSchedules\SubjectSchedulesIndex')->name('subject_schedules.index');
Route::get('/subject_schedules/create', 'SubjectSchedules\CreateSubjectSchedule')->name('subject_schedules.create');
Route::get('/subject_schedules/{subjectSchedule}', 'SubjectSchedules\ShowSubjectSchedule')->name('subject_schedules.show');
Route::get('/subject_schedules/{subjectSchedule}/edit', 'SubjectSchedules\EditSubjectSchedule')->name('subject_schedules.edit');


/**
 * Begin route definition for `Buildings` resources.
 */
Route::get('/buildings', 'Buildings\BuildingsIndex')->name('buildings.index');
Route::get('/buildings/create', 'Buildings\CreateBuilding')->name('buildings.create');
Route::get('/buildings/{building}', 'Buildings\ShowBuilding')->name('buildings.show');
Route::get('/buildings/{building}/edit', 'Buildings\EditBuilding')->name('buildings.edit');


/**
 * Begin route definition for `Classrooms` resources.
 */
Route::get('/classrooms', 'Classrooms\ClassroomsIndex')->name('classrooms.index');
Route::get('/classrooms/create', 'Classrooms\CreateClassroom')->name('classrooms.create');
Route::get('/classrooms/{classroom}', 'Classrooms\ShowClassroom')->name('classrooms.show');
Route::get('/classrooms/{classroom}/edit', 'Classrooms\EditClassroom')->name('classrooms.edit');
