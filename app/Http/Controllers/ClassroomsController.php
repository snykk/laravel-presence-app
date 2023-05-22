<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomSaveRequest;
use App\Http\Resources\ClassroomCollection;
use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use App\QueryBuilders\ClassroomBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Classroom Management
 *
 * API Endpoints for managing classrooms.
 */
class ClassroomsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * ClassroomsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Classroom::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the classroom resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[classrooms] *string* - No-example
     * Comma-separated field/attribute names of the classroom resource to include in the response document.
     * The available fields for current endpoint are: `id`, `building_id`, `room_number`, `capacity`, `floor`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[building] *string* - No-example
     * Comma-separated field/attribute names of the building resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `building`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `building_id`, `room_number`, `capacity`, `floor`, `status`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `building_id`, `room_number`, `capacity`, `floor`, `status`, `created_at`, `updated_at`, `building.id`, `building.name`, `building.address`, `building.created_at`, `building.updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\ClassroomBuilder $query
     *
     * @return ClassroomCollection
     */
    public function index(ClassroomBuilder $query): ClassroomCollection
    {
        return new ClassroomCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new classroom resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\ClassroomSaveRequest $request
     * @param \App\Models\Classroom $classroom
     *
     * @return JsonResponse
     */
    public function store(ClassroomSaveRequest $request, Classroom $classroom): JsonResponse
    {
        $classroom->fill($request->only($classroom->offsetGet('fillable')))
            ->save();

        $resource = (new ClassroomResource($classroom))
            ->additional(['info' => 'The new classroom has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific classroom resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam classroom required *integer* - No-example
     * The identifier of a specific classroom resource.
     *
     * @queryParam fields[classrooms] *string* - No-example
     * Comma-separated field/attribute names of the classroom resource to include in the response document.
     * The available fields for current endpoint are: `id`, `building_id`, `room_number`, `capacity`, `floor`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[building] *string* - No-example
     * Comma-separated field/attribute names of the building resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `building`.
     *
     * @param \App\QueryBuilders\ClassroomBuilder $query
     * @param \App\Models\Classroom $classroom
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return ClassroomResource
     */
    public function show(ClassroomBuilder $query, Classroom $classroom): ClassroomResource
    {
        return new ClassroomResource($query->find($classroom->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific classroom resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam classroom required *integer* - No-example
     * The identifier of a specific classroom resource.
     *
     * @param \App\Http\Requests\ClassroomSaveRequest $request
     * @param \App\Models\Classroom $classroom
     *
     * @return ClassroomResource
     */
    public function update(ClassroomSaveRequest $request, Classroom $classroom): ClassroomResource
    {
        $classroom->fill($request->only($classroom->offsetGet('fillable')));

        if ($classroom->isDirty()) {
            $classroom->save();
        }

        return (new ClassroomResource($classroom))
            ->additional(['info' => 'The classroom has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific classroom resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam classroom required *integer* - No-example
     * The identifier of a specific classroom resource.
     *
     * @param \App\Models\Classroom $classroom
     *
     * @throws \Exception
     *
     * @return ClassroomResource
     */
    public function destroy(Classroom $classroom): ClassroomResource
    {
        $classroom->delete();

        return (new ClassroomResource($classroom))
            ->additional(['info' => 'The classroom has been deleted.']);
    }
}
