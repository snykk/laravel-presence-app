<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleSaveRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\QueryBuilders\ScheduleBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Schedule Management
 *
 * API Endpoints for managing schedules.
 */
class SchedulesController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * SchedulesController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Schedule::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the schedule resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[schedules] *string* - No-example
     * Comma-separated field/attribute names of the schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `subjectSchedules`, `subjects`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\ScheduleBuilder $query
     *
     * @return ScheduleCollection
     */
    public function index(ScheduleBuilder $query): ScheduleCollection
    {
        return new ScheduleCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new schedule resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\ScheduleSaveRequest $request
     * @param \App\Models\Schedule $schedule
     *
     * @return JsonResponse
     */
    public function store(ScheduleSaveRequest $request, Schedule $schedule): JsonResponse
    {
        $schedule->fill($request->only($schedule->offsetGet('fillable')))
            ->save();

        $resource = (new ScheduleResource($schedule))
            ->additional(['info' => 'The new schedule has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam schedule required *integer* - No-example
     * The identifier of a specific schedule resource.
     *
     * @queryParam fields[schedules] *string* - No-example
     * Comma-separated field/attribute names of the schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `subjectSchedules`, `subjects`.
     *
     * @param \App\QueryBuilders\ScheduleBuilder $query
     * @param \App\Models\Schedule $schedule
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return ScheduleResource
     */
    public function show(ScheduleBuilder $query, Schedule $schedule): ScheduleResource
    {
        return new ScheduleResource($query->find($schedule->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam schedule required *integer* - No-example
     * The identifier of a specific schedule resource.
     *
     * @param \App\Http\Requests\ScheduleSaveRequest $request
     * @param \App\Models\Schedule $schedule
     *
     * @return ScheduleResource
     */
    public function update(ScheduleSaveRequest $request, Schedule $schedule): ScheduleResource
    {
        $schedule->fill($request->only($schedule->offsetGet('fillable')));

        if ($schedule->isDirty()) {
            $schedule->save();
        }

        return (new ScheduleResource($schedule))
            ->additional(['info' => 'The schedule has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam schedule required *integer* - No-example
     * The identifier of a specific schedule resource.
     *
     * @param \App\Models\Schedule $schedule
     *
     * @throws \Exception
     *
     * @return ScheduleResource
     */
    public function destroy(Schedule $schedule): ScheduleResource
    {
        $schedule->delete();

        return (new ScheduleResource($schedule))
            ->additional(['info' => 'The schedule has been deleted.']);
    }
}
