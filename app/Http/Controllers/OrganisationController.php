<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListOrganisationResource;
use App\Http\Resources\OrganisationResource;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisations = Organisation::query();

        if ($request->has('name')) {
            $organisations->where('org_name', 'like', '%' . $request->input('name') . '%');
            $organisations = $organisations->with(['parent', 'sisters', 'daughters'])->paginate();

            $organisations = $this->getFamilyMemeber($organisations, $request->input('name'));
            $page = $request->get('page', 1);

            return OrganisationResource::collection(
                new LengthAwarePaginator($organisations->forPage($page, 100), $organisations->count(), 100)
            );
        }

        return ListOrganisationResource::collection($organisations->paginate(100));
    }

    public function getFamilyMemeber($organisations, $searched)
    {
        $collection = new Collection();

        foreach ($organisations as $organisation) {

            if(isset($organisation->parent) && $organisation->parent->org_name != $searched )
                $collection->push(['org_name' => $organisation->parent->org_name, 'relation_type' => 'parent']);

            foreach ($organisation->daughters as $daughter) {
                if($daughter->org_name != $searched)
                    $collection->push(['org_name' => $daughter->org_name, 'relation_type' => 'daughter']);
            }

            foreach ($organisation->sisters as $sister) {
                if($sister->org_name != $searched)
                    $collection->push(['org_name' => $sister->org_name, 'relation_type' => 'sister']);
            }
        }

        return $collection->sortBy('org_name')->unique();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organisation = Organisation::create($request->all());

        return response()->json($organisation);
    }

    
}
