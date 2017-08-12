import React, { Component } from 'react';

//components imports
import ReactPaginate from 'react-paginate';
import validator from 'validator';

export default class WorkspaceSettingsPane extends Component {
    constructor(props) {
        super(props);
        this.state ={
            workspace: tk.workspace,
            user: {
                offset: 0,
                perPage: 10,
            },
            project: {
                offset: 0,
                perPage: 10,
            },
            client: {
                offset: 0,
                perPage: 10,
            },
            newUser: "",
            addingUser: false,
            errors: {}
        };

    }

    componentWillMount(){
        //get all users, get all projects and get all clients
        this.getAllClients();
        this.getAllProjects();
        this.getAllUsers();
    }

    updateWorkspace(evt){
        let newState = this.state;
        newState.workspace[evt.target.name] = evt.target.value;
        this.setState(newState);
    }

    updateInput(evt){
        let newState = this.state;
        newState[evt.target.name] = evt.target.value;
        this.setState(newState);
    }

    updatePerPage(evt){
        let newState = this.state;
        newState[evt.target.name].perPage = evt.target.value;
        this.setState(newState);
    }

    getAllClients(){
        let self = this;
        axios.post('/workspaces/getAllClients/' + this.state.workspace.id)
            .then(function(response){
                let newState = self.state;
                newState.clients = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    getAllUsers(){
        let self = this;
        axios.post('/workspaces/getAllUsers/' + this.state.workspace.id)
            .then(function(response){
                let newState = self.state;
                newState.users = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    getAllProjects(){
        let self = this;
        axios.post('/workspaces/getAllProjects/' + this.state.workspace.id)
            .then(function(response){
                let newState = self.state;
                newState.projects = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    addNewUser(){
        // if(!validator.isEmail(this.state.newUser)){
        //     this.setState({userError: "Invalid email"});
        //     return;
        // }

        let self = this;
        axios.post('/workspaces/inviteUsers/'+this.state.workspace.id, {
            data: {
                userEmails: [
                    self.state.newUser
                ]
            }
        }).then(function(response){
            if(response.status == 201){
                self.setState({newUser: "", addingUser: false, userError: null})
                self.props.showSuccess();
            }
        }).catch(function(error){
            if(error.response.status == 400){
                let errorMessage = error.response.data.errors['userEmails.0'][0];
                self.setState({userError: errorMessage});
                self.props.showError();
            }
        });

    }

    saveWorkspace(){
        let self = this;
        axios.post('/workspaces/edit/' + this.state.workspace.id, {
            data: this.state.workspace
        }).then(function(response){
            if(response.status == 200){
                let newState = self.state;
                newState.errors = {};
                self.setState(newState);
                self.props.showSuccess();
            }
        }).catch(function(error){
            if(error.response){
                if(error.response.status){
                    self.props.showError();
                    self.setState({errors: error.response.data.errors});
                    console.log(error.response);
                }
            }
        })
    }

    handlePageClick(type, data){
        let newState = this.state;
        let selected = data.selected;
        newState[type].offset = Math.ceil(selected * newState[type].perPage);
        this.setState(newState);
    };

    render() {

        let currentUsers = null;
        if(this.state.users){
            currentUsers = this.state.users.slice(this.state.user.offset, (this.state.user.offset + parseInt(this.state.user.perPage)));
        }

        let currentProjects = null;
        if(this.state.projects){
            currentProjects = this.state.projects.slice(this.state.project.offset, (this.state.project.offset + parseInt(this.state.project.perPage)));
        }

        let currentClients = null;
        if(this.state.clients){
            currentClients = this.state.clients.slice(this.state.client.offset, (this.state.client.offset + parseInt(this.state.client.perPage)));
        }

        return (
            <div>
            {(() => {
                switch(this.props.activeView){
                    case 1:
                        return (
                            <div className="pane medium-container margin-center">
                                <div className="row">
                                    <div className="col-xs-12 ">
                                        <label>Workspace Name:</label>
                                        <input
                                            type="text"
                                            className="tk-form-input"
                                            name="name"
                                            value={this.state.workspace.name}
                                            onChange={this.updateWorkspace.bind(this)}

                                        />
                                        {this.state.errors.name
                                            ? <small className="error">{this.state.errors.name}</small>
                                            : ''
                                        }
                                    </div>
                                    {/*ToDo: Add in description text area*/}
                                </div>
                                <div className="row">
                                    <div className="col-xs-12 text-right">
                                        <button className="btn tk-btn-success" onClick={this.saveWorkspace.bind(this)}>Save</button>
                                    </div>
                                </div>
                            </div>
                        );
                    case 2:
                        return (
                            <div className="pane medium-container margin-center">
                                {
                                    currentUsers
                                    ?
                                    <div>
                                        <label>Display: </label>
                                            <select value={this.state.user.perPage} onChange={this.updatePerPage.bind(this)} name="user">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                            </select>

                                            <ul className="no-list-style no-margin no-padding list">
                                            {
                                                currentUsers.map((user, id) => (
                                                    <li key={id}>{user.title}</li>
                                                ))
                                            }
                                            </ul>
                                            <div className="row">
                                                <div className="col-xs-12 text-center">
                                                    <ReactPaginate previousLabel={"previous"}
                                                                   nextLabel={"next"}
                                                                   breakLabel={<a href="">...</a>}
                                                                   breakClassName={"break-me"}
                                                                   pageCount={Math.ceil(this.state.users.length / this.state.user.perPage)}
                                                                   marginPagesDisplayed={2}
                                                                   pageRangeDisplayed={5}
                                                                   onPageChange={this.handlePageClick.bind(this, 'user')}
                                                                   containerClassName={"pagination"}
                                                                   subContainerClassName={"pages pagination"}
                                                                   activeClassName={"active"} />
                                                </div>
                                            </div>
                                    </div>
                                    :
                                    <div>
                                        No users to display.
                                    </div>

                                }

                                <div className="row">
                                    <div className="col-xs-12 text-center">
                                        {/*ToDo: Implement*/}
                                        {
                                            this.state.addingUser
                                            ?
                                                <div>
                                                    <input
                                                        type="text"
                                                        value={this.state.newUser}
                                                        onChange={this.updateInput.bind(this)}
                                                        name="newUser"
                                                        className="tk-form-input"
                                                        placeholder="Enter an email address..."
                                                    />
                                                    {
                                                        this.state.userError &&
                                                        <small className="error">{this.state.userError}</small>
                                                    }
                                                    <button
                                                        className="btn tk-btn-success"
                                                        onClick={this.addNewUser.bind(this)}
                                                    >
                                                        Send Invite
                                                    </button>
                                                </div>
                                            :
                                                <a href="#" onClick={() => this.setState({addingUser: true})}>+ Add User</a>

                                        }
                                    </div>
                                </div>
                            </div>
                        );
                    case 3:
                        return (
                            <div className="pane medium-container margin-center">
                                {
                                    currentProjects
                                    ?
                                    <div>
                                        <label>Display: </label>
                                        <select value={this.state.project.perPage} onChange={this.updatePerPage.bind(this)} name="project">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>

                                        {
                                            this.state.projects.length
                                            ?
                                                <ul className="no-list-style no-margin no-padding list">
                                                    {
                                                        currentProjects.map((project, id) => (
                                                            <li key={id}>{project.title}</li>
                                                        ))
                                                    }
                                                </ul>
                                            :
                                                <div>
                                                    <br/>
                                                    You have no projects to display.
                                                    <br/>
                                                </div>
                                        }

                                        <div className="row">
                                            <div className="col-xs-12 text-center">
                                                <ReactPaginate previousLabel={"previous"}
                                                               nextLabel={"next"}
                                                               breakLabel={<a href="">...</a>}
                                                               breakClassName={"break-me"}
                                                               pageCount={Math.ceil(this.state.projects.length / this.state.project.perPage)}
                                                               marginPagesDisplayed={2}
                                                               pageRangeDisplayed={5}
                                                               onPageChange={this.handlePageClick.bind(this, 'project')}
                                                               containerClassName={"pagination"}
                                                               subContainerClassName={"pages pagination"}
                                                               activeClassName={"active"} />
                                            </div>
                                        </div>
                                    </div>
                                    :
                                    <div>
                                        No projects to display, get to work!
                                    </div>
                                }
                                {/*<div className="row">*/}
                                    {/*<div className="col-xs-12 text-center">*/}
                                        {/*/!*ToDo: Improve so the project creation page auto fills in the workspace *!/*/}
                                        {/*<a href="/projects/create">+ Add Project</a>*/}
                                    {/*</div>*/}
                                {/*</div>*/}
                            </div>
                        );
                    case 4:
                        return (
                            <div className="pane medium-container margin-center">
                                {
                                    currentClients
                                        ?
                                        <div>
                                            <label>Display: </label>
                                            <select value={this.state.clients.perPage} onChange={this.updatePerPage.bind(this)} name="client">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                            </select>

                                            {
                                                this.state.clients.length
                                                ?
                                                    <ul className="no-list-style no-margin no-padding list">
                                                        {
                                                            currentClients.map((client, id) => (
                                                                <li key={id}>{client.title}</li>
                                                            ))
                                                        }
                                                    </ul>
                                                :
                                                    <div>
                                                        <br/>
                                                        You have no clients to display.
                                                        <br/>
                                                    </div>
                                            }

                                            <div className="row">
                                                <div className="col-xs-12 text-center">
                                                    <ReactPaginate previousLabel={"previous"}
                                                                   nextLabel={"next"}
                                                                   breakLabel={<a href="">...</a>}
                                                                   breakClassName={"break-me"}
                                                                   pageCount={Math.ceil(this.state.clients.length / this.state.client.perPage)}
                                                                   marginPagesDisplayed={2}
                                                                   pageRangeDisplayed={5}
                                                                   onPageChange={this.handlePageClick.bind(this, 'client')}
                                                                   containerClassName={"pagination"}
                                                                   subContainerClassName={"pages pagination"}
                                                                   activeClassName={"active"} />
                                                </div>
                                            </div>
                                        </div>
                                        :
                                        <div>
                                            No clients to display. Try some networking groups!
                                        </div>
                                }
                                {/*<div className="row">*/}
                                    {/*<div className="col-xs-12 text-center">*/}
                                        {/*/!*ToDo: Improve so the client creation page auto fills in the workspace*/}
                                         {/*instead of using current*!/*/}
                                        {/*<a href="/clients/create">+ Add Client</a>*/}
                                    {/*</div>*/}
                                {/*</div>*/}
                            </div>
                        );
                }
            }) ()}
            </div>


        );
    }
}





