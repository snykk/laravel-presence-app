<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectScheduleSaveRequest;
use App\Http\Resources\SubjectScheduleCollection;
use App\Http\Resources\SubjectScheduleResource;
use App\Models\SubjectSchedule;
use App\QueryBuilders\SubjectScheduleBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Subject Schedule Management
 *
 * API Endpoints for managing subject schedules.
 */
class SubjectSchedulesController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * SubjectSchedulesController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(SubjectSchedule::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the subject schedule resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[subject_schedules] *string* - No-example
     * Comma-separated field/attribute names of the subject_schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `subject_id`, `schedule_id`, `created_at`, `updated_at`.
     * @queryParam fields[subject] *string* - No-example
     * Comma-separated field/attribute names of the subject resource to include in the response document.
     * The available fields for current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`.
     * @queryParam fields[schedule] *string* - No-example
     * Comma-separated field/attribute names of the schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `subject`, `schedule`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `subject_id`, `schedule_id`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `subject_id`, `schedule_id`, `created_at`, `updated_at`, `subject.id`, `subject.department_id`, `subject.code`, `subject.score_credit`, `subject.created_at`, `subject.updated_at`, `schedule.id`, `schedule.seq`, `schedule.start_time`, `schedule.end_time`, `schedule.created_at`, `schedule.updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\SubjectScheduleBuilder $query
     *
     * @return SubjectScheduleCollection
     */
    public function index(SubjectScheduleBuilder $query): SubjectScheduleCollection
    {
        return new SubjectScheduleCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new subject schedule resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\SubjectScheduleSaveRequest $request
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return JsonResponse
     */
    public function store(SubjectScheduleSaveRequest $request, SubjectSchedule $subjectSchedule): JsonResponse
    {
        $subjectSchedule->fill($request->only($subjectSchedule->offsetGet('fillable')))
            ->save();

        $resource = (new SubjectScheduleResource($subjectSchedule))
            ->additional(['info' => 'The new subject schedule has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific subject schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subjectSchedule required *integer* - No-example
     * The identifier of a specific subject schedule resource.
     *
     * @queryParam fields[subject_schedules] *string* - No-example
     * Comma-separated field/attribute names of the subject_schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `subject_id`, `schedule_id`, `created_at`, `updated_at`.
     * @queryParam fields[subject] *string* - No-example
     * Comma-separated field/attribute names of the subject resource to include in the response document.
     * The available fields for current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`.
     * @queryParam fields[schedule] *string* - No-example
     * Comma-separated field/attribute names of the schedule resource to include in the response document.
     * The available fields for current endpoint are: `id`, `seq`, `start_time`, `end_time`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `subject`, `schedule`.
     *
     * @param \App\QueryBuilders\SubjectScheduleBuilder $query
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return SubjectScheduleResource
     */
    public function show(SubjectScheduleBuilder $query, SubjectSchedule $subjectSchedule): SubjectScheduleResource
    {
        return new SubjectScheduleResource($query->find($subjectSchedule->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific subject schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subjectSchedule required *integer* - No-example
     * The identifier of a specific subject schedule resource.
     *
     * @param \App\Http\Requests\SubjectScheduleSaveRequest $request
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return SubjectScheduleResource
     */
    public function update(SubjectScheduleSaveRequest $request, SubjectSchedule $subjectSchedule): SubjectScheduleResource
    {
        $subjectSchedule->fill($request->only($subjectSchedule->offsetGet('fillable')));

        if ($subjectSchedule->isDirty()) {
            $subjectSchedule->save();
        }

        return (new SubjectScheduleResource($subjectSchedule))
            ->additional(['info' => 'The subject schedule has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific subject schedule resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subjectSchedule required *integer* - No-example
     * The identifier of a specific subject schedule resource.
     *
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @throws \Exception
     *
     * @return SubjectScheduleResource
     */
    public function destroy(SubjectSchedule $subjectSchedule): SubjectScheduleResource
    {
        $subjectSchedule->delete();

        return (new SubjectScheduleResource($subjectSchedule))
            ->additional(['info' => 'The subject schedule has been deleted.']);
    }
}
