<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectSaveRequest;
use App\Http\Resources\SubjectCollection;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\QueryBuilders\SubjectBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Subject Management
 *
 * API Endpoints for managing subjects.
 */
class SubjectsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * SubjectsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Subject::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the subject resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[subjects] *string* - No-example
     * Comma-separated field/attribute names of the subject resource to include in the response document.
     * The available fields for current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`.
     * @queryParam fields[department] *string* - No-example
     * Comma-separated field/attribute names of the department resource to include in the response document.
     * The available fields for current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `department`, `subjectSchedules`, `subjectTranslations`, `schedules`, `translations`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`, `department.id`, `department.code`, `department.created_at`, `department.updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\SubjectBuilder $query
     *
     * @return SubjectCollection
     */
    public function index(SubjectBuilder $query): SubjectCollection
    {
        return new SubjectCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new subject resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\SubjectSaveRequest $request
     * @param \App\Models\Subject $subject
     *
     * @return JsonResponse
     */
    public function store(SubjectSaveRequest $request, Subject $subject): JsonResponse
    {
        $subject->fill($request->only($subject->offsetGet('fillable')))
            ->save();

        $resource = (new SubjectResource($subject))
            ->additional(['info' => 'The new subject has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific subject resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subject required *integer* - No-example
     * The identifier of a specific subject resource.
     *
     * @queryParam fields[subjects] *string* - No-example
     * Comma-separated field/attribute names of the subject resource to include in the response document.
     * The available fields for current endpoint are: `id`, `department_id`, `code`, `score_credit`, `created_at`, `updated_at`.
     * @queryParam fields[department] *string* - No-example
     * Comma-separated field/attribute names of the department resource to include in the response document.
     * The available fields for current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `department`, `subjectSchedules`, `subjectTranslations`, `schedules`, `translations`.
     *
     * @param \App\QueryBuilders\SubjectBuilder $query
     * @param \App\Models\Subject $subject
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return SubjectResource
     */
    public function show(SubjectBuilder $query, Subject $subject): SubjectResource
    {
        return new SubjectResource($query->find($subject->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific subject resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subject required *integer* - No-example
     * The identifier of a specific subject resource.
     *
     * @param \App\Http\Requests\SubjectSaveRequest $request
     * @param \App\Models\Subject $subject
     *
     * @return SubjectResource
     */
    public function update(SubjectSaveRequest $request, Subject $subject): SubjectResource
    {
        $subject->fill($request->only($subject->offsetGet('fillable')));

        if ($subject->isDirty()) {
            $subject->save();
        }

        return (new SubjectResource($subject))
            ->additional(['info' => 'The subject has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific subject resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam subject required *integer* - No-example
     * The identifier of a specific subject resource.
     *
     * @param \App\Models\Subject $subject
     *
     * @throws \Exception
     *
     * @return SubjectResource
     */
    public function destroy(Subject $subject): SubjectResource
    {
        $subject->delete();

        return (new SubjectResource($subject))
            ->additional(['info' => 'The subject has been deleted.']);
    }
}
