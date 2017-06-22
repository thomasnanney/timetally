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
            clients: []
        }
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    componentWillMount(){
        console.log(this.state);
        let self = this;
        axios.post('/users/getAllClients')
            .then(function(response){
                self.setState({clients: response.data});
                if(self.state.clients.length > 0){
                    console.log("Adding initial client");
                    //set initial value for client in state
                    let newProject = self.state.project;
                    newProject.clientID = self.state.clients[0].id
                    self.setState({project: newProject});
                }
            })
            .catch(function(error){
                alert('We were unable to retrieve all clients, please reload the page or contact your System' +
                    ' Administrator');
            });


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

    createProject(){
        console.log(this.state);
        axios.post('/projects/create', {
            data: this.state.project
        })
            .then(function(response){
                console.log(response.data);
            })
            .catch(function(error){
               alert("We were unable to create your project, please try again");
            });
    }

    addUserField(){
        let newProject = this.state.project;
        newProject.users.push('');
        this.setState((prevState, props) => ({
            project : newProject
        }));
        console.log(this.state.project);
    };

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
                                        </div>
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            {
                                                this.state.project.billableType == 'fixed'
                                                    ?
                                                    <input
                                                        type="text"
                                                        name="projectedRevenue"
                                                        className="tk-form-input"
                                                        placeholder="$$$ Total Cost..."
                                                        value={this.state.project.projectedRevenue}
                                                        onChange={this.updateInput.bind(this)}
                                                    />
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
                                                    <input
                                                        type="text"
                                                        name="billableRate"
                                                        className="tk-form-input"
                                                        placeholder="$$$ Hourly Rate"
                                                        value={this.state.project.billableRate}
                                                        onChange={this.updateInput.bind(this)}
                                                    />
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
                                        <label>
                                            End Date:
                                        </label>
                                        <input name="endDate"
                                               type="date"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        <label>
                                            Estimated Completion Time (hours):
                                        </label>
                                        <input name="projectedTime"
                                               type="text"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                        />
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
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right"
                                                                                                     aria-hidden="true"></i></a>
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
                                        ></textarea>
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