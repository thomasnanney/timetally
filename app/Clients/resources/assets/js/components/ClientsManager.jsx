import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

//components imports
import ListItem from 'clients/ClientManagerComponents/ListItem';
import SearchBar from 'clients/ClientManagerComponents/SearchBar';
import Modal from 'core/Modal';

class ClientsManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
            clients: [],
            promptDelete: false,
            promptDeleteClient: null
        };
    }

    componentDidMount() {

    }

    componentWillMount(){
        this.updateClients();
    }

    componentWillUnmount() {

    }

    updateClients(){
        let self=this;
        //get clients to display
        axios.post('/users/getAllClients')
            .then(function (response){
                self.setState({clients: response.data});
            })
            .catch(function(error){
                alert("It appears there was an error retrieving clients.  Please try again or contact your system" +
                    " administrator");
            });
    }

    promptToDelete(client){
        let newState = this.state;
        newState.promptDelete = true;
        newState.promptDeleteClient = client;
        this.setState(newState);
    }

    cancelDelete(){
        let newState = this.state;
        newState.promptDelete = false;
        newState.promptDeleteClient = null;
        this.setState(newState);
    }

    removeClient(){
        let self = this;
        axios.post('/clients/delete' + this.state.promptDeleteClient.id)
            .then(function(response){
                if(response.status == 200){
                    if(response.data.status == "success"){
                        self.updateClients();
                    }
                }
            })
            .catch(function(error){
               console.log(error)
            });
    }

    render() {

        let header = '';
        let body = '';
        if(this.state.promptDelete){
            header = 'Are you sure?';
            body = 'Are you sure you want to delete ' + this.state.promptDeleteClient.name;
        }

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12">
                        <span className="tk-header">Clients</span>
                        <a href="/clients/create" className="btn tk-btn pull-right">Add Client</a>
                    </div>
                </div>
                <br></br>
                <div className="row">
                    <div className="col-xs-12">
                        <SearchBar />
                    </div>
                </div>
                <div className="list table clients-list">
                    <div className="list-header table-row thick-border-bottom">
                        <div className="table-cell valign-bottom"></div>
                        <div className="table-cell valign-bottom">
                            Client
                        </div>
                        <div className="table-cell valign bottom">
                        </div>
                    </div>
                    {this.state.clients.length > 0 ?
                        this.state.clients.map((client) =>
                            <ListItem client={client} key={client.id} removeClient={this.promptToDelete.bind(this)}/>
                        )
                        :
                        <p>You do not have any clients...Get to Work!</p>
                    }
                </div>
                {this.state.promptDelete &&
                    <Modal show={true} header={header} body={body} onConfirm={this.removeClient.bind(this)} onClose={this.cancelDelete.bind(this)} />
                }
            </div>
        );
    }
}

if(document.getElementById('clientsManager')){
    console.log("manager present");
    ReactDOM.render(<ClientsManager />, document.getElementById('clientsManager'));
}