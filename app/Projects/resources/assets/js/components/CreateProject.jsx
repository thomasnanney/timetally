import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class CreateProject extends Component{

    constructor(props){
        super(props);
        this.state = {
            step: 1,
            project: {
                title: '',
                scope: 'public',
                workspaceID: '',
                clientID: '',
                billableType: 'fixed',
                startDate: '',
                endDate: '',
                projectedTime: '',
                projectedRevenue: '',
                billableRate: '',
                billableHourlyType: 'project',
                users: [],
                description: ''
            },
            clients: [],
            errors: {},
            workspaces: []
        }
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    componentWillMount(){
        let self = this;
        axios.post('/users/getAllClients')
            .then(function(response){
                self.setState({clients: response.data});
                if(self.state.clients.length > 0){
                    //set initial value for client in state
                    let newProject = self.state.project;
                    newProject.clientID = self.state.clients[0].id
                    self.setState({project: newProject});
                }
            })
            .catch(function(error){
                console.log(error);
                alert('We were unable to retrieve all clients, please reload the page or contact your System' +
                    ' Administrator');
            });

        // axios.post('/users/getAllWorkspaces')
        //     .then(function(response){
        //         self.setState({workspaces: response.data});
        //         if(self.state.workspaces.length >0){
        //             let newProject = self.state.project;
        //             newProject.workspaceID = self.state.workspaces[0].id;
        //             self.setState({project: newProject});
        //         }
        //     })
        //     .catch(function(error){
        //         console.log(error);
        //         alert('We were unable to retrieve all of your workspaces, please reload the page or contact your' +
        //             ' System Administrator');
        //     });
    }

    nextStep(){
        if(this.state.step == 3 && this.state.project.scope == 'public') {
            this.setState({step: this.state.step + 2});
        }else{
            this.setState({step: this.state.step + 1});
        }
    }

    prevStep(){
        if(this.state.step == 5 && this.state.project.scope == 'public') {
            this.setState({step: this.state.step - 2});
        }else{
            this.setState({step: this.state.step - 1});
        }
    }

    createProject(){
        let self = this;

        axios.post('/projects/create', {
            data: self.state.project
        })
            .then(function(response){
                if(response.status == 200){
                    if(response.data.errors == "true"){
                        console.log("Setting state errors");
                        console.log(response.data.messages);
                        let errors = response.data.messages;
                        self.setState({errors: errors});
                        self.setState({step: 1});
                    }else{
                        window.location.href = '/projects';
                    }
                }
            })
            .catch(function(error){
                console.log(error);
               alert("We were unable to create your project, please try again");
            });
    }

    addUserField(){
        let newProject = this.state.project;
        newProject.users.push('');
        this.setState((prevState, props) => ({
            project : newProject
        }));
    };

    //ToDo: convert to updateInput for dynamic fields as well via arrays
    updateUserName(id, evt){
        let users = this.state.project.users.slice();
        users[id] = evt.target.value;
        let newProject = this.state.project;
        newProject.users = users;
        this.setState({project: newProject});
    }

    updateInput(event){
        let name = event.target.name;
        let value = event.target.value;
        this.updateState(name, value);
    }

    updateState(name, value){
        let newProject = this.state.project;
        newProject[name] = value;
        this.setState({ project: newProject});
    }

    updateCheckbox(event){
        let name = event.target.name;
        let value = event.target.checked;
        if(name == 'scope'){
            if(value){
                this.updateState(name, 'private');
            }else{
                this.updateState(name, 'public');
            }
        }
        if(name == 'billableType'){
            if(value){
                this.updateState(name, 'hourly');
            }else{
                this.updateState(name, 'fixed');
            }
        }
        if(name == 'billableHourlyType'){
            if(value){
                this.updateState(name, 'employee');
            }else{
                this.updateState(name, 'project');
            }
        }
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
                                                            <option value={workspace.id} key={workspace.id}>{workspace.name}</option>
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
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right" aria-hidden="true"></i></a>
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
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.createProject()}>Finish <i className="fa fa-chevron-right"
                                                                                                       aria-hidden="true"></i></a>
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

if(document.getElementById('createProject')){
    ReactDOM.render(<CreateProject/>, document.getElementById('createProject'));
}