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

        $response = $this->call('POST', '/clients/create',

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

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);

    }

    public function testCreateClientNoName()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => '',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Company Name', $data['messages']['name'][0]);
    }

    public function testCreateClientNoEmail()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => '',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an eMail', $data['messages']['email'][0]);

    }

    public function testCreateClientInvalidEmail()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a valid eMail', $data['messages']['email'][0]);

    }

    public function testCreateClientNoAddress1()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => '',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Address', $data['messages']['address1'][0]);

    }

    public function testCreateClientNoAddress2()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

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

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Address2', $data['messages']['address2'][0]);

    }

    public function testCreateClientNoCity()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => '',

                    'state' => 'TX',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a City', $data['messages']['city'][0]);

    }

    public function testCreateClientNoState()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => '',

                    'postalCode' => '78254',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a State', $data['messages']['state'][0]);

    }

    public function testCreateClientNoPostalCode()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a valid Postal Code. xxxxx[-xxxx]', $data['messages']['postalCode'][0]);

    }

    public function testCreateClientInvalidPostalCode()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 1',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Address 2',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => 's78sa2s',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'name' => 'Client 1'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a valid Postal Code. xxxxx[-xxxx]', $data['messages']['postalCode'][0]);

    }

    public function testCreateClientNoDescription()

    {

        $user = factory(User::class)->make();

        $this->be($user);

        $response = $this->call('POST', '/clients/create',

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

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testEditClientNoName()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/'.$client->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => '',

                    'email' => 'client@example.com',

                    'address1' => 'Address 1',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Company Name', $data['messages']['name'][0]);
    }

    public function testEditClientNoEmail()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/'.$client->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 2',

                    'email' => '',

                    'address1' => 'Address 1',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an eMail', $data['messages']['email'][0]);
    }

    public function testEditClientInvalidEmail()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/'.$client->id,

            array(

                '_token' => csrf_token(),

                'data' => [

                    'name' => 'Client 2',

                    'email' => 'client',

                    'address1' => 'Address 1',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a valid eMail', $data['messages']['email'][0]);
    }

    public function testEditClientNoAddress1()
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

                    'address1' => '',

                    'address2' => 'Suite 700',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Address', $data['messages']['address1'][0]);
    }

    public function testEditClientNoAddress2()
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

                    'address2' => '',

                    'city' => 'San Antonio',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter an Address2', $data['messages']['address2'][0]);
    }

    public function testEditClientNoCity()
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

                    'city' => '',

                    'state' => 'TX',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a City', $data['messages']['city'][0]);
    }

    public function testEditClientNoState()
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

                    'state' => '',

                    'postalCode' => '78240',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a State', $data['messages']['state'][0]);
    }

    public function testEditClientNoPostalCode()
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

                    'postalCode' => '',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a Postal Code', $data['messages']['postalCode'][0]);
    }

    public function testEditClientInvalidPostalCode()
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

                    'postalCode' => 'abcdef',

                    'description' => 'A description',

                ]

            ));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('Please enter a valid Postal Code', $data['messages']['postalCode'][0]);
    }

    public function testEditClientNoDescription()
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

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('success', $data['status']);
    }

    public function testEditClientInvalidID()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/19023842093854',

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

        $this->assertDatabaseMissing('clients', [

            'id' => $client->id,
            'name' => 'Client 2'

        ]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('fail', $data['status']);
        $this->assertEquals('true', $data['errors']);
        $this->assertEquals('No client found', $data['messages'][0]);
    }

    public function testEditClientNoID()
    {
        $user = factory(User::class)->make();

        $this->be($user);

        $client = factory(Client::class)->create();

        $response = $this->call('POST', '/clients/edit/',

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

        $this->assertEquals(404, $response->getStatusCode());

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
