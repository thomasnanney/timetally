import React, { Component } from 'react';

//components imports
import validator from 'validator';

export default class AddWorkspaceWizard extends Component {

    constructor(props) {
        super(props);
        this.state = {
            step: 1,
            name: '',
            users: [],
            error: null
        };

        this.nextStep = this.nextStep.bind(this);
        this.addWorkspace = this.addWorkspace.bind(this);
        this.setName = this.setName.bind(this);
        this.addUserField = this.addUserField.bind(this);
        this.updateUserName = this.updateUserName.bind(this);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    nextStep(){
        let name = this.state.name;
        let users = this.state.users;
        let step = this.state.step;
        let error = this.state.error;

        if(step == 2){
            if(name.length == 0){
                error = "You must enter a name";
            }
            else if(name.length < 3){
                error = "The name must be at least 3 characters";
            }
        }
        if(step == 3){
            //clear out empty users fields
            users = users.filter(Boolean);
        }

        if(error){
            this.setState({error: error});
            return;
        }else{
            this.setState({error: error});
        }

        this.setState((prevState, props) => ({
            step: prevState.step + 1,
        }));
    }

    addWorkspace(){
        let self = this;
        if(this.state.error){
            alert("You must fix the errors before saving");
            return;
        }else{
            axios.post('/workspaces/create', {
                data: {
                    name: self.state.name
                },
                users: self.state.users
            }).then(function(response){
                self.setState({step: 1});
                self.props.updateWorkspaces();
            }).catch(function(error){
                console.log(error);
                alert("There was an error creating your workspace, please try reloading the page.");
            });
        }
    }

    setName(event){
        let inputName = event.target.value;
        this.setState({
            name: inputName
        });
    };

    addUserField(){
        this.setState((prevState, props) => ({
            users: prevState.users.concat(['']),
        }))
    };

    updateUserName(id, evt){
        let email = evt.target.value;

        let users = this.state.users.slice();
        users[id] = email;
        this.setState({users: users});

        if(email && !validator.isEmail(email)){
            this.setState({error: "Invalid email address"});
        }else{
            this.setState({error: null});
        }
    }

    render() {
        return (
            <div className="add-workspace-wizard margin-center">
                {(() => {
                    switch(this.state.step){
                        case 1:
                            return <button onClick={this.nextStep} className="btn tk-btn">Add Workspace</button>
                        case 2:
                            return (
                                <div>
                                    <p>Give your workspace a name</p>
                                    <input type="text" className="tk-form-input" value={this.state.name} placeholder="Workspace name..." onChange={this.setName}/>
                                    <button onClick={this.nextStep} className="btn tk-btn">Continue</button>
                                </div >
                            );
                        case 3:
                            return  (
                                <div>
                                    <p>Add Users</p>
                                    {
                                        this.state.users.map((user, id) => (
                                            <input type="text" className="tk-form-input" placeholder="User's Email..." value={this.state.users[id]} onChange={this.updateUserName.bind(this, id)}/>
                                        ))
                                    }
                                    <button onClick={this.addUserField} className="btn tk-btn">Add User</button>
                                    <button onClick={this.addWorkspace} className="btn tk-btn">Finish</button>
                                </div>
                            );
                        default:
                            return <p>Sorry we experienced an error.  Try reloading the page.</p>
                    }
                }) ()}
                {
                    this.state.error
                    ? <small className="error">{this.state.error}</small>
                    : ''
                }
            </div>
        );
    }
}