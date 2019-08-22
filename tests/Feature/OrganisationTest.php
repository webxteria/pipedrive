<?php

namespace Tests\Feature;

use App\Models\Organisation;
use Tests\TestCase;

class OrganisationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_response_200_on_create_organisation()
    {
        $this->post('/api/organisations', [
            'org_name' => 'Paradise Island',
            'children' => [
                [
                    'org_name' => 'Banana tree',
                ],
            ],
        ])->assertStatus(200);
    }

    /** @test */
    public function it_should_response_with_array()
    {
        $this->post('/api/organisations', [
            'org_name' => 'Paradise Island',
            'children' => [
                [
                    "org_name" => "Banana tree",
                ],
            ],
        ])->assertJsonStructure(
            [
                'id',
                'org_name',
                '_lft',
                '_rgt',
                'updated_at',
                'created_at',
                'children' => [
                    '*' => [
                        'id',
                        'org_name',
                        '_lft',
                        '_rgt',
                        'updated_at',
                        'created_at',
                    ],
                ],
            ]
        );
    }

    /** @test */
    public function it_should_store_data_in_database()
    {
        $response = $this->post('/api/organisations', [
            'org_name' => 'Paradise Island',
            'children' => [
                [
                    "org_name" => "Banana tree",
                ],
            ],
        ]);

        $this->assertDatabaseHas('organisations', ['id' => $response->getData()->id, 'org_name' => $response->getData()->org_name]);
    }

    /** @test */
    public function it_should_response_with_200_get_organisation()
    {
        $this->get('/api/organisations')->assertStatus(200);
    }

    /** @test */
    public function it_should_response_with_other_members_on_search_get_organisation()
    {
        $paradiseIsland = factory(Organisation::class)->create([
            'org_name' => 'Paradise Island',
        ]);

        $bananaTree = factory(Organisation::class)->create([
            'org_name' => 'Banana Tree',
            'parent_id' => $paradiseIsland->id,
        ]);

        $bigBananaTree = factory(Organisation::class)->create([
            'org_name' => 'Big banana tree',
            'parent_id' => $paradiseIsland->id,
        ]);

        $yellowBanana = factory(Organisation::class)->create([
            'org_name' => 'Yellow Banana',
            'parent_id' => $bananaTree->id,
        ]);

        $brownTree = factory(Organisation::class)->create([
            'org_name' => 'Brown Banana',
            'parent_id' => $bananaTree->id,
        ]);

        $blackTree = factory(Organisation::class)->create([
            'org_name' => 'Black Banana',
            'parent_id' => $bananaTree->id,
        ]);

        $blackBigTree = factory(Organisation::class)->create([
            'org_name' => 'Yellow Banana',
            'parent_id' => $bigBananaTree->id,
        ]);

        $brownBigTree = factory(Organisation::class)->create([
            'org_name' => 'Brown Banana',
            'parent_id' => $bigBananaTree->id,
        ]);

        $greenBigTree = factory(Organisation::class)->create([
            'org_name' => 'Green Banana',
            'parent_id' => $bigBananaTree->id,
        ]);

        $blackBigTree = factory(Organisation::class)->create([
            'org_name' => 'Black Banana',
            'parent_id' => $bigBananaTree->id,
        ]);

        $blackBigTree = factory(Organisation::class)->create([
            'org_name' => 'Phoneutria Spider',
            'parent_id' => $blackBigTree->id,
        ]);

        $this->get('/api/organisations?name=Black Banana')->assertJson([
            'data' => [
                '0' => [
                    'org_name' => 'Banana Tree',
                    'relation_type' => 'parent',
                ],
                '1' => [
                    'org_name' => 'Big banana tree',
                    'relation_type' => 'parent',
                ],
                '2' => [
                    'org_name' => 'Brown Banana',
                    'relation_type' => 'sister',
                ],
                '3' => [
                    'org_name' => 'Green Banana',
                    'relation_type' => 'sister',
                ],
                '4' => [
                    'org_name' => 'Phoneutria Spider',
                    'relation_type' => 'daughter',
                ],
                '5' => [
                    'org_name' => 'Yellow Banana',
                    'relation_type' => 'sister',
                ],

            ],
            'links' => [
                'first' => '/?page=1',
                'last' => '/?page=1',
                'prev' => null,
                'next' => null,
            ],
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'path' => "/",
                'per_page' => 100,
                'to' => 6,
                'total' => 6,
            ]
        ]);
    }

    /** @test */
    public function it_should_response_with_other_empty_array_on_search_no_result()
    {
        factory(Organisation::class, 5)->create([
            'parent_id' => factory(Organisation::class)->create(),
        ]);

        $this->get('/api/organisations?name=Black Banana')->assertJsonFragment([
            'data' => [],
        ]);
    }

    /** @test */
    public function it_should_response_with_array_get_organisation()
    {
        factory(Organisation::class, 100000)->create([
            'parent_id' => factory(Organisation::class)->create(),
        ]);

        $this->get('/api/organisations')->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'org_name',
                    '_lft',
                    '_rgt',
                    'parent_id',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

}
