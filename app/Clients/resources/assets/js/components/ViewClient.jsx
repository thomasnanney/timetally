import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports

import ViewClientPane from 'clients/ViewClientComponents/ViewClientPane'

class ViewClient extends Component {

    constructor(props) {
        super(props);
        this.state ={
            activeView: 1,
            client: tk.client,
            errors: null,
        };
    }

    componentDidMount() {

    }

    componentWillMount(){

    }

    componentWillUnmount() {

    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }

    updateClient(prop, value){
        let newState = this.state;
        newState.client[prop] = value;
        this.setState(newState);
    }

    saveClient(){
        let self = this;
        axios.post('/clients/edit/' + self.state.client.id,
            {
                data: self.state.client
            }
        )
            .then(function(response){
               if(response.status == 200){
                   if(response.data.status == "success"){
                       alert("Client Updated!");
                       self.setState({errors: null});
                   }else if(response.data.status == "fail" && response.data.errors == "true"){
                       self.setState({errors: response.data.messages});
                   }
               }
            })
            .catch(function(error){
                console.log(error);
            });
    }

    render() {

        const tabs = [
            'General',
            'Details',
            'Projects'
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
                    <ViewClientPane activeView={this.state.activeView} updateClient={this.updateClient.bind(this)} client={this.state.client} saveClient={this.saveClient.bind(this)} errors={this.state.errors}/>
                </div>
            </div>
        );
    }
}

if(document.getElementById('viewClient')){
    ReactDOM.render(<ViewClient />, document.getElementById('viewClient'));
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
    ]

    let hasErrors = false;

    if(errors){
        Object.keys(errors).forEach(function(field){
            for(let key in errorFields[pane]){
                console.log("Field: " + field + '\tKey: ' +  errorFields[pane][key] + " == " + (field == key));
                if(field ==  errorFields[pane][key]){
                    hasErrors = true;
                    break;
                }
            }
        });
    }

    return hasErrors;
}