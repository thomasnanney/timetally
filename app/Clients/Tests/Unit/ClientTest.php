<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientTest extends TestCase

{

    use DatabaseTransactions;


    public function testClientIndex()
    {
        $user = factory(\App\Users\Models\User::class)->make();

        $this->be($user);

        $response = $this->call('GET', '/clients/');

        $this->assertEquals(200, $response->getStatusCode());




    }

    /**

     * A basic test example.

     *

     * @return void

     */

    public function testCreateClient()

    {

        $user = factory(\App\Users\Models\User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => '',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => '',

                ]

            ));

        var_dump($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }


    public function testEditClient()
    {
        $user = factory(\App\Users\Models\User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/edit/10',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 2',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'sadfasdf',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => '',

                ]

            ));

        var_dump($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteClient()
    {
        $this->assertTrue(true);
    }

}
