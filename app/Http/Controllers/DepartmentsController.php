<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentSaveRequest;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\QueryBuilders\DepartmentBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Department Management
 *
 * API Endpoints for managing departments.
 */
class DepartmentsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * DepartmentsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Department::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the department resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[departments] *string* - No-example
     * Comma-separated field/attribute names of the department resource to include in the response document.
     * The available fields for current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `departmentTranslations`, `translations`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\DepartmentBuilder $query
     *
     * @return DepartmentCollection
     */
    public function index(DepartmentBuilder $query): DepartmentCollection
    {
        return new DepartmentCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new department resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\DepartmentSaveRequest $request
     * @param \App\Models\Department $department
     *
     * @return JsonResponse
     */
    public function store(DepartmentSaveRequest $request, Department $department): JsonResponse
    {
        $department->fill($request->only($department->offsetGet('fillable')))
            ->save();

        $resource = (new DepartmentResource($department))
            ->additional(['info' => 'The new department has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific department resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam department required *integer* - No-example
     * The identifier of a specific department resource.
     *
     * @queryParam fields[departments] *string* - No-example
     * Comma-separated field/attribute names of the department resource to include in the response document.
     * The available fields for current endpoint are: `id`, `code`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `departmentTranslations`, `translations`.
     *
     * @param \App\QueryBuilders\DepartmentBuilder $query
     * @param \App\Models\Department $department
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return DepartmentResource
     */
    public function show(DepartmentBuilder $query, string $locale, Department $department): DepartmentResource
    {
        return new DepartmentResource($query->find($department->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific department resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam department required *integer* - No-example
     * The identifier of a specific department resource.
     *
     * @param \App\Http\Requests\DepartmentSaveRequest $request
     * @param \App\Models\Department $department
     *
     * @return DepartmentResource
     */
    public function update(DepartmentSaveRequest $request, Department $department): DepartmentResource
    {
        $department->fill($request->only($department->offsetGet('fillable')));

        if ($department->isDirty()) {
            $department->save();
        }

        return (new DepartmentResource($department))
            ->additional(['info' => 'The department has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific department resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam department required *integer* - No-example
     * The identifier of a specific department resource.
     *
     * @param \App\Models\Department $department
     *
     * @throws \Exception
     *
     * @return DepartmentResource
     */
    public function destroy(Department $department): DepartmentResource
    {
        $department->delete();

        return (new DepartmentResource($department))
            ->additional(['info' => 'The department has been deleted.']);
    }
}
