<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingSaveRequest;
use App\Http\Resources\BuildingCollection;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\QueryBuilders\BuildingBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Building Management
 *
 * API Endpoints for managing buildings.
 */
class BuildingsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * BuildingsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Building::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the building resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[buildings] *string* - No-example
     * Comma-separated field/attribute names of the building resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `classrooms`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\BuildingBuilder $query
     *
     * @return BuildingCollection
     */
    public function index(BuildingBuilder $query): BuildingCollection
    {
        return new BuildingCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new building resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\BuildingSaveRequest $request
     * @param \App\Models\Building $building
     *
     * @return JsonResponse
     */
    public function store(BuildingSaveRequest $request, Building $building): JsonResponse
    {
        $building->fill($request->only($building->offsetGet('fillable')))
            ->save();

        $resource = (new BuildingResource($building))
            ->additional(['info' => 'The new building has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific building resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam building required *integer* - No-example
     * The identifier of a specific building resource.
     *
     * @queryParam fields[buildings] *string* - No-example
     * Comma-separated field/attribute names of the building resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `address`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `classrooms`.
     *
     * @param \App\QueryBuilders\BuildingBuilder $query
     * @param \App\Models\Building $building
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return BuildingResource
     */
    public function show(BuildingBuilder $query, Building $building): BuildingResource
    {
        return new BuildingResource($query->find($building->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific building resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam building required *integer* - No-example
     * The identifier of a specific building resource.
     *
     * @param \App\Http\Requests\BuildingSaveRequest $request
     * @param \App\Models\Building $building
     *
     * @return BuildingResource
     */
    public function update(BuildingSaveRequest $request, Building $building): BuildingResource
    {
        $building->fill($request->only($building->offsetGet('fillable')));

        if ($building->isDirty()) {
            $building->save();
        }

        return (new BuildingResource($building))
            ->additional(['info' => 'The building has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific building resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam building required *integer* - No-example
     * The identifier of a specific building resource.
     *
     * @param \App\Models\Building $building
     *
     * @throws \Exception
     *
     * @return BuildingResource
     */
    public function destroy(Building $building): BuildingResource
    {
        $building->delete();

        return (new BuildingResource($building))
            ->additional(['info' => 'The building has been deleted.']);
    }
}
