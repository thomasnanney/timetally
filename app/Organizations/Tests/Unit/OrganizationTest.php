<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Users\Models\User as User;
use App\Organizations\Models\Organization as Organization;

class OrganizationTest extends TestCase

{

    use DatabaseTransactions;


    public function testOrganizationIndex()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('GET', '/organizations/');

        $this->assertEquals(200, $response->getStatusCode());




    }

    /**

     * A basic test example.

     *

     * @return void

     */

    public function testCreateOrganization()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/organizations',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Organization 1',

                    'email' => 'organization@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('organizations', [

            'name' => 'Organization 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }


    public function testEditOrganization()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $organization = factory(Organization::class)->create();

        $response = $this->call('POST', '/organizations/edit/'.$organization->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Organization 2',

                    'email' => 'organization@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('organizations', [

            'name' => 'Organization 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteOrganization()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $organization = factory(Organization::class)->create();

        $response = $this->call('DELETE', '/organizations/delete/'.$organization->id,

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testDeleteOrganizationNoId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/organizations/delete/',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(404, $response->getStatusCode());

        //ToDo: make 404 page
        //shoudl redirect to  a cusotm 404 page
    }

    public function testDeleteOrganizationInvalidId()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('DELETE', '/organizations/delete/19023842093854',

            array(

                '_token' => csrf_token(),

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Organization not found', $data['messages'][0]);
    }

}
