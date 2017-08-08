import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import CreateClientPane from './CreateClientComponents/CreateClientPane';

class CreateClient extends Component{

    constructor(props){
        super(props);
        this.state = {
            activeView: 1,
            client: {
                name: '',
                email: '',
                address1: '',
                address2: '',
                city: '',
                state: '',
                postalCode: '',
                description: '',
            },
            errors: {},
        }
    }

    componentWillMount(){

    }

    updateClient(evt){
        let newState = this.state;
        newState.client[evt.target.name] = evt.target.value;
        this.setState(newState);
    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }

    createClient(){
        let self = this;
        console.log(self.state.client);
        axios.post('/clients/create', {
            data: self.state.client
        })
            .then(function(response){
                console.log(response.data);
                if(response.status == 200){
                    if(response.data.errors == "true"){
                        console.log("Setting state errors");
                        console.log(response.data.messages);
                        let errors = response.data.messages;
                        self.setState({errors: errors});
                    }
                    if(response.data.status == "success"){
                        self.setState({errors: null});
                        window.location.href = "/clients";
                    }
                }
            })
            .catch(function(error){
                console.log(error);
                alert("We were unable to create your client, please try again");
            });
    }

    render(){

        const tabs = [
            'General',
            'Details',
        ];

        return (
            <div className="tile raise">
                <div className="row">
                    <div className="col-xs-12">
                        <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                            {
                                tabs.map((tab, id) =>
                                    <li className={"tab " + (this.state.activeView == id+1 ? 'active ': '') + (hasErrors(id, this.state.errors) ? 'pane-error ' : '')} onClick={() => this.makeTabActive(id+1)} key={id}>{tab}</li>
                                )
                            }
                        </ul>
                    </div>
                </div>
                <div className="pane-container">
                    <CreateClientPane activeView={this.state.activeView} updateClient={this.updateClient.bind(this)} client={this.state.client} saveClient={this.createClient.bind(this)} errors={this.state.errors}/>
                </div>
            </div>
        );
    }
}

function hasErrors(pane, errors){
    const errorFields = [
        [
            'name',
            'email'
        ],
        [
            'address1',
            'address2',
            'city',
            'state',
            'postalCode'
        ]
    ];

    let hasErrors = false;

    if(errors){
        Object.keys(errors).forEach(function(field){
            for(let key in errorFields[pane]){
                if(field ==  errorFields[pane][key]){
                    hasErrors = true;
                    break;
                }
            }
        });
    }

    return hasErrors;
}

if(document.getElementById('createClient')){
    ReactDOM.render(<CreateClient/>, document.getElementById('createClient'));
}