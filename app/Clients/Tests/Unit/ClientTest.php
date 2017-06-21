<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;
use App\Clients\Models\Client as Client;

class ClientTest extends TestCase

{

    use DatabaseTransactions;


    public function testClientIndex()
    {
        $user = factory(User::class)->make();

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

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => '',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }


    public function testEditClient()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/'.$client->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 2',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => '',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteClient()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('DELETE', '/clients/delete/'.$client->id,

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteClientNoId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/clients/delete/',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(404, $response->getStatusCode());

        //ToDo: make 404 page
        //shoudl redirect to  a cusotm 404 page
    }

    public function testDeleteClientInvalidId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/clients/delete/19023842093854',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Client not found', $data['messages'][0]);
    }

}
