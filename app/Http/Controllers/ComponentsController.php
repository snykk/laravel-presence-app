<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComponentCollection;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\QueryBuilders\ComponentBuilder;

/**
 * @group Component Management
 *
 * API Endpoints for managing components.
 */
class ComponentsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * ComponentsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Component::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the component resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[components] *string* - No-example
     * Comma-separated field/attribute names of the component resource to include in the response document.
     * The available fields for current endpoint are: `id`, `published_at`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `translations`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `published_at`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `published_at`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`.
     *
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\ComponentBuilder $query
     *
     * @return ComponentCollection
     */
    public function index(ComponentBuilder $query): ComponentCollection
    {
        return new ComponentCollection($query->paginate());
    }

    /**
     * Show Resource.
     * Display a specific component resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam component required *integer* - No-example
     * The identifier of a specific component resource.
     *
     * @queryParam fields[components] *string* - No-example
     * Comma-separated field/attribute names of the component resource to include in the response document.
     * The available fields for current endpoint are: `id`, `published_at`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `translations`.
     *
     * @param \App\QueryBuilders\ComponentBuilder $query
     * @param \App\Models\Component               $component
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return ComponentResource
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function show(ComponentBuilder $query, string $locale, Component $component): ComponentResource
    {
        return new ComponentResource($query->find($component->getKey()));
    }
}
