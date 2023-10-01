<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponderHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    use ResponderHelper;

    private $tenantModel;
    private $relations;

    public function __construct()
    {
        $this->tenantModel = new Tenant();
        $this->relations = [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $order_field = $request->order_field ?? 'id';
        $order_sort = $request->order_sort ?? 'desc';

        $data = $this->tenantModel
            ->with($this->relations)
            ->when($request->search != "", function ($q) use ($request) {
                $q->where('domain', 'LIKE', '%' . $request->search . '%');
            })
            ->orderBy($order_field, $order_sort)
            ->paginate($limit);

        return $this->responsePaginate(TenantResource::class, $data, ['query' => $request->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request)
    {

        $tenant = $this->tenantModel->create(['id' => $request->domain]);
        $tenant->domains()->create(['domain' => $request->domain . '.' . env('APP_CENTRAL_DOMAIN')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
