import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import ListItem from 'clients/ClientManagerComponents/ListItem';
import SearchBar from 'clients/ClientManagerComponents/SearchBar';

class ClientsManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
        };

        this.addWorkspace = this.addWorkspace.bind(this);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    addWorkspace(name){
        let workspaces = this.state.workspaces.slice();
        workspaces[this.state.workspaces.length] = name;
        this.setState({workspaces: workspaces});
    }

    render() {

        const  clients = [
            {
                name: 'Client 1',
                link: '/clients/view/1'
            },
            {
                name: 'Client 2',
                link: '/clients/view/1'
            },
            {
                name: 'Client 3',
                link: '/clients/view/1'
            },
        ];

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12">
                        <span className="tk-header">Clients</span>
                        <a href="/clients/add" className="btn tk-btn pull-right">Add Client</a>
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
                            Workspace
                        </div>
                        <div className="table-cell valign bottom">
                        </div>
                    </div>
                    {clients.length > 0 ?
                        clients.map((client, id) =>
                            <ListItem client={client} key={id}/>
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