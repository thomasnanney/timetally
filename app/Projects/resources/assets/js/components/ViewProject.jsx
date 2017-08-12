import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ReactLoading from 'react-loading';

//components imports
import DateFormat from 'dateformat';
import SuccessNotification from 'core/SuccessNotification';
import ErrorNotification from 'core/ErrorNotification';

class ViewProject extends Component {

    constructor(props) {
        super(props);
        this.state = {
            activeView: 0,
            project: tk.project,
            users: [],
            clients: [],
            errors: {},
            workspaces: [],
            addingUser: false,
            showSuccess: false,
            showError: false,
        };
    }

    componentWillMount(){

        let self = this;
        axios.post('/users/getAllClients')
            .then(function(response){
                self.setState({clients: response.data});
            })
            .catch(function(error){
                alert('We were unable to retrieve all clients, please reload the page or contact your System' +
                    ' Administrator');
            });

        axios.post('/projects/getUsers/' + this.state.project.id)
            .then(function(response){
                self.setState({users:response.data});
            })
            .catch(function(error){
                alert('We were unable to retrieve all users for this project, please reload the page or contact your' +
                    ' System' +
                    ' Administrator');
            });

        let newState = this.state;
        newState.project.startDate = DateFormat(newState.project.startDate, 'yyyy-mm-dd');
        newState.project.endDate = DateFormat(newState.project.endDate, 'yyyy-mm-dd');
        this.setState(newState);
    }

    saveProject(){
        let self = this;

        axios.post('/projects/edit/' + self.state.project.id, {
            data: self.state.project,
            users: self.state.users
        })
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    self.showSuccess();
                }
            })
            .catch(function(error){
                if(error.response.status == 400){
                    let errors = error.response.data.messages;
                    self.setState({errors: errors});
                    self.showError();
                }
                console.log(error);
            });
    }

    addUserField(){
        let newState = this.state;
        newState.users.push('');
        this.setState(newState);
    };

    //ToDo: convert to updateInput for dynamic fields as well via arrays
    updateUserName(id, evt){
        let users = this.state.users.slice();
        users[id] = evt.target.value;
        let newState = this.state;
        newState.users = users;
        this.setState(newState);
    }

    updateInput(event){
        let name = event.target.name;
        let value = event.target.type == 'checkbox' ? event.target.checked : event.target.value;
        this.updateProject(name, value);
    }

    updateProject(name, value){
        let newProject = this.state.project;
        newProject[name] = value;
        this.setState({ project: newProject});
    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }

    showSuccess(){
        let self = this;
        this.setState({showSuccess: true});
        window.setTimeout(function(){
            self.setState({showSuccess: false});
        }, 3000);
    }

    showError(){
        let self = this;
        this.setState({showError: true});
        window.setTimeout(function(){
            self.setState({showError: false});
        }, 3000);
    }

    render(){

        const tabs = [
            'General',
            'Details',
            'Finance',
            'Users',
        ];

        return(
            <div>
                <SuccessNotification show={this.state.showSuccess}/>
                <ErrorNotification show={this.state.showError}/>
                <div className="tile raise">
                    <div className="row">
                        <div className="col-xs-12">
                            <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                                {
                                    tabs.map((tab, id) =>
                                        <li className={"tab " + (this.state.activeView == id ? 'active ': '') + (hasErrors(id, this.state.errors) ? 'pane-error ' : '')} onClick={() => this.makeTabActive(id)} key={id}>{tab}</li>
                                    )
                                }
                            </ul>
                        </div>
                    </div>
                    <div className="pane-container">
                        {(() => {
                            switch (this.state.activeView) {
                                case 0:
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
                                            </div>
                                            <br></br>
                                            <div className="row">
                                                <div className="col-xs-12">
                                                    Public
                                                    <label className="switch">
                                                        <input type="checkbox"
                                                               name="private"
                                                               checked={this.state.project.private}
                                                               onChange={this.updateInput.bind(this)}

                                                        />
                                                        <div className="slider round"></div>
                                                    </label>
                                                    Private
                                                    {this.state.errors.private
                                                        ? <small className="error">{this.state.errors.private}</small>
                                                        : ''
                                                    }
                                                </div>
                                            </div>
                                            <br/>
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
                                    );
                                case 1:
                                    return (<div className="pane medium-container margin-center">
                                        <div>
                                            <h1>Details</h1>
                                            <label>Client</label>
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
                                        <label>
                                            Start Date:
                                        </label>
                                        <input name="startDate"
                                               type="date"
                                               className="tk-form-input"
                                               onChange={this.updateInput.bind(this)}
                                               value={DateFormat(this.state.project.startDate, 'yyyy-mm-dd')}
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
                                               value={DateFormat(this.state.project.endDate, 'yyyy-mm-dd')}
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
                                               value={this.state.project.projectedTime}
                                        />
                                        {this.state.errors.projectedTime
                                            ? <small className="error">{this.state.errors.projectedTime}</small>
                                            : ''
                                        }
                                    </div>);
                                case 2:
                                    return (
                                        <div className="pane medium-container margin-center">
                                            <div>
                                                <label>Projected Revenue</label>
                                                <input
                                                    type="text"
                                                    name="projectedRevenue"
                                                    className="tk-form-input"
                                                    placeholder="$$$ Projected Revenue"
                                                    value={this.state.project.projectedRevenue}
                                                    onChange={this.updateInput.bind(this)}
                                                />
                                                {this.state.errors.projectedRevenue
                                                    ? <small className="error">{this.state.errors.projectedRevenue}</small>
                                                    : ''
                                                }
                                                <label>Projected Cost</label>
                                                <input
                                                    type="text"
                                                    name="projectedCost"
                                                    className="tk-form-input"
                                                    placeholder="$$$ Projected Cost"
                                                    value={this.state.project.projectedCost}
                                                    onChange={this.updateInput.bind(this)}
                                                />
                                                {this.state.errors.projectedRevenue
                                                    ? <small className="error">{this.state.errors.projectedCost}</small>
                                                    : ''
                                                }
                                            </div>
                                        </div>);
                                case 3:
                                    return (
                                        <div className="pane medium-container margin-center">
                                            {
                                                this.state.project.private
                                                    ?
                                                    <div>
                                                        <div>
                                                            <h1>Add Users</h1>
                                                            {
                                                                this.state.users.map((user, id) => (
                                                                    typeof user == 'string'
                                                                    ?
                                                                        <input type="text"
                                                                               className="tk-form-input"
                                                                               placeholder="User's Email..."
                                                                               value={user}
                                                                               key={id}
                                                                               onChange={this.updateUserName.bind(this, id)}
                                                                        />
                                                                    :
                                                                        <input type="text"
                                                                               className="tk-form-input"
                                                                               placeholder="User's Email..."
                                                                               value={user.name + '   ('+user.email+')'}
                                                                               key={id}
                                                                               onChange={this.updateUserName.bind(this, id)}
                                                                        />
                                                                ))
                                                            }
                                                        </div>
                                                        <br/>
                                                        <div className="row">
                                                            <div className="col-xs-12 text-center">
                                                                <button onClick={() => this.addUserField()} className="btn tk-btn">Add User</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    :
                                                    <div>
                                                        <p>This project is public, all users in the workspace will be able to view it and add time entries</p>
                                                    </div>
                                            }
                                        </div>);
                            }
                        }) ()}
                        <div className="row">
                            <div className="col-xs-12 text-right">
                                <button className="btn tk-btn-success" onClick={this.saveProject.bind(this)}>Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

function hasErrors(pane, errors){
    const errorFields = [
        [
            'title',
            'workspaceID',
            'private',
            'description'
        ],
        [
            'clientID',
            'startDate',
            'endDate',
            'projectedTime',
        ],
        [
            'projectedRevenue',
            'projectedCost',
        ],
        [
            'users'
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

if(document.getElementById('viewProject')){
    ReactDOM.render(<ViewProject/>, document.getElementById('viewProject'));
}