import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

//components imports
import ListItem from 'clients/ClientManagerComponents/ListItem';
import SearchBar from 'clients/ClientManagerComponents/SearchBar';

class ClientsManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
            clients: []
        };
    }

    componentDidMount() {

    }

    componentWillMount(){
        var self=this;
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

    componentWillUnmount() {

    }

    render() {

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
                            <ListItem client={client} key={client.id}/>
                        )
                        :
                        <p>You do not have any clients...Get to Work!</p>
                    }
                </div>
            </div>
        );
    }
}

if(document.getElementById('clientsManager')){
    console.log("manager present");
    ReactDOM.render(<ClientsManager />, document.getElementById('clientsManager'));
}