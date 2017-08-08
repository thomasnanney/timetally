import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class CreateClient extends Component{

    constructor(props){
        super(props);
        this.state = {
            step: 1,
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
        this.getAllClients();
        this.getAllWorkspaces();
    }

    updateClient(evt){
        let newState = this.state;
        newState[evt.target.name] = evt.target.value;
        this.setState(newState);
    }

    nextStep(){
        this.setState((prevState, props) => ({
            step: prevState.step + 1
        }));
    }

    prevStep(){
        this.setState((prevState, props) => ({
            step: prevState.step - 1
        }));
    }

    createClient(){
        let self = this;
        console.log(self.state.client);
        axios.post('/clients/create', {
            data: self.state.client
        })
            .then(function(response){
                if(response.status == 200){
                    if(response.data.errors == "true"){
                        console.log("Setting state errors");
                        console.log(response.data.messages);
                        let errors = response.data.messages;
                        self.setState({errors: errors});
                        self.setState({step: 1});
                    }
                }
            })
            .catch(function(error){
                console.log(error);
                alert("We were unable to create your project, please try again");
            });
    }

    render(){
        return(
            <div className="tile raise">
                <div className="pane-container">
                    {(() => {
                        switch (this.state.step) {
                            case 1:
                                return (
                                    <div className="pane medium-container margin-center">
                                        <div>
                                            <h1>Project Name</h1>
                                            <input
                                                type="text"
                                                name="title"
                                                className="tk-form-input"
                                                placeholder="Project Name..."
                                                value={this.state.project.title}
                                                onChange={this.updateInput.bind(this)}
                                            />
                                            {this.state.errors.title
                                                ? <small className="error">{this.state.errors.title}</small>
                                                : ''
                                            }
                                            {this.state.workspaces.length > 1 &&
                                            <div>
                                                <h1>Workspace</h1>
                                                <select className="tk-form-input"
                                                        value={this.state.project.workspaceID}
                                                        onChange={this.updateInput.bind(this)}
                                                        name="workspaceID">
                                                    {
                                                        this.state.workspaces.length > 0
                                                            ?
                                                            this.state.workspaces.map((workspace) =>
                                                                <option value={workspace.id} key={workspace.id}>{workspace.title}</option>
                                                            )
                                                            :
                                                            <option>Add a workspace</option>
                                                    }
                                                </select>
                                            </div>
                                            }
                                            {this.state.errors.workspaceID
                                                ? <small className="error">{this.state.errors.workspaceID}</small>
                                                : ''
                                            }
                                        </div>
                                        <br></br>
                                        <div className="row">
                                            <div className="col-xs-12">
                                                Public
                                                <label className="switch">
                                                    <input type="checkbox"
                                                           name="scope"
                                                           checked={this.state.project.scope == 'private'}
                                                           onChange={this.updateCheckbox.bind(this)}

                                                    />
                                                    <div className="slider round"></div>
                                                </label>
                                                Private
                                                {this.state.errors.scope
                                                    ? <small className="error">{this.state.errors.scope}</small>
                                                    : ''
                                                }
                                            </div>
                                        </div>
                                        <br></br>
                                        <div className="row">
                                            <div className="col-xs-12">
                                                <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right" aria-hidden="true">&nbsp;</i></a>
                                            </div>
                                        </div>
                                    </div>
                                );
                            case 2:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Client</h1>
                                        <select className="tk-form-input"
                                                value={this.state.project.clientID}
                                                onChange={this.updateInput.bind(this)}
                                                name="clientID">
                                            {
                                                this.state.clients.length > 0
                                                    ?
                                                    this.state.clients.map((client) =>
                                                        <option value={client.id} key={client.id}>{client.name}</option>
                                                    )
                                                    :
                                                    <option>Add a client</option>
                                            }
                                        </select>
                                        {this.state.errors.clientID
                                            ? <small className="error">{this.state.errors.clientID}</small>
                                            : ''
                                        }
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            Fixed Price
                                            <label className="switch">
                                                <input
                                                    type="checkbox"
                                                    name="billableType"
                                                    checked = {this.state.project.billableType == 'hourly'}
                                                    onChange={this.updateCheckbox.bind(this)}
                                                />
                                                <div className="slider round"></div>
                                            </label>
                                            Billed Hourly
                                            {this.state.errors.billableType
                                                ? <small className="error">{this.state.errors.billableType}</small>
                                                : ''
                                            }
                                        </div>
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            {
                                                this.state.project.billableType == 'fixed'
                                                    ?
                                                    <div>
                                                        <input
                                                            type="text"
                                                            name="projectedRevenue"
                                                            className="tk-form-input"
                                                            placeholder="$$$ Total Cost..."
                                                            value={this.state.project.projectedRevenue}
                                                            onChange={this.updateInput.bind(this)}
                                                        />
                                                        {this.state.errors.projectedRevenue
                                                            ? <small className="error">{this.state.errors.projectedRevenue}</small>
                                                            : ''
                                                        }
                                                    </div>
                                                    :
                                                    <div>
                                                        Project Hourly Rate
                                                        <label className="switch">
                                                            <input
                                                                type="checkbox"
                                                                name="billableHourlyType"
                                                                checked={this.state.project.billableHourlyType == 'employee'}
                                                                onChange={this.updateCheckbox.bind(this)}
                                                            />
                                                            <div className="slider round"></div>
                                                        </label>
                                                        Employee Hourly Rate
                                                        {this.state.errors.projectedRevenue
                                                            ? <small className="error">{this.state.errors.projectedRevenue}</small>
                                                            : ''
                                                        }
                                                    </div>
                                            }
                                        </div>
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            {
                                                this.state.project.billableHourlyType == 'project' && this.state.project.billableType == 'hourly'
                                                    ?
                                                    <div>
                                                        <input
                                                            type="text"
                                                            name="billableRate"
                                                            className="tk-form-input"
                                                            placeholder="$$$ Hourly Rate"
                                                            value={this.state.project.billableRate}
                                                            onChange={this.updateInput.bind(this)}
                                                        />
                                                        {this.state.errors.billableRate
                                                            ? <small className="error">{this.state.errors.billableRate}</small>
                                                            : ''
                                                        }
                                                    </div>
                                                    :

                                                    ''
                                            }
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right"
                                                                                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>);
                            case 3:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Details</h1>
                                        <label>
                                            Start Date:
                                        </label>
                                        <input name="startDate"
                                               type="date"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        {this.state.errors.startDate
                                            ? <small className="error">{this.state.errors.startDate}</small>
                                            : ''
                                        }
                                        <label>
                                            End Date:
                                        </label>
                                        <input name="endDate"
                                               type="date"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        {this.state.errors.endDate
                                            ? <small className="error">{this.state.errors.endDate}</small>
                                            : ''
                                        }
                                        <label>
                                            Estimated Completion Time (hours):
                                        </label>
                                        <input name="projectedTime"
                                               type="text"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        {this.state.errors.projectedTime
                                            ? <small className="error">{this.state.errors.projectedTime}</small>
                                            : ''
                                        }
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right"
                                                                                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>);
                            case 4:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Add Users</h1>
                                        {
                                            this.state.project.users.map((user, id) => (
                                                <input type="text"
                                                       className="tk-form-input"
                                                       placeholder="User's Email..."
                                                       value={user}
                                                       key={id}
                                                       onChange={this.updateUserName.bind(this, id)}
                                                />
                                            ))
                                        }
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12 text-center">
                                            <button onClick={() => this.addUserField()} className="btn tk-btn">Add User</button>
                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"/>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right" aria-hidden="true"/></a>
                                        </div>
                                    </div>
                                </div>);
                            case 5:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Project Details</h1>
                                        <textarea name="description"
                                                  className="tk-form-textarea"
                                                  placeholder="Project Description..."
                                                  onChange={this.updateInput.bind(this)}
                                        />
                                        {this.state.errors.description
                                            ? <small className="error">{this.state.errors.description}</small>
                                            : ''
                                        }
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"/>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.createProject()}>Finish <i className="fa fa-chevron-right"
                                                                                                                                            aria-hidden="true"/></a>
                                        </div>
                                    </div>
                                </div>);
                        }
                    }) ()}
                </div>
            </div>
        );
    }
}

if(document.getElementById('createClient')){
    ReactDOM.render(<CreateClient/>, document.getElementById('createClient'));
}