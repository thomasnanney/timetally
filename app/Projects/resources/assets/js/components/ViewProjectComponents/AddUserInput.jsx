import React, { Component } from 'react';
//components imports

export default class AddUserInput extends Component {

    constructor(props){
        super(props);
        this.state = {
            users: [],
            user: ''
        }
    }

    componentWillMount(){
        let self = this;
        axios.post('/workspaces/getAllUsers/' + this.props.workspaceID)
            .then(function(response){
                if(response.status == 200){
                    self.setState({users: response.data});
                    self.setState({user: response.data[0]});
                }
                console.log(response);
            }).catch(function(error){
                console.log(error);
                alert("We were unable to retrieve all users for you to choose who to add.  Please reload the page or" +
                    " contact your System Administrator");
        });
    }

    updateUser(event){
        let value = event.target.value;
        let newUser = this.state.users.filter(function(user){
           return user.id == value;
        });
        this.setState({user: newUser[0]});
    }

    submitAddUser(){
        this.props.toggleAddUser();
        this.props.addUser(this.state.user)
    }

    render(){

        return(
            <div>
                <select className="tk-form-input" value={this.state.userID} onChange={this.updateUser.bind(this)} name="userID">
                    {
                        this.state.users.length > 0
                            ?
                            this.state.users.map((user) =>
                                <option value={user.id} key={user.id}>{user.name}</option>
                            )
                            :
                            <option>Add a User</option>
                    }
                </select>
                <div className="row">
                    <div className="col-xs-12">
                        <button type="button" className="btn btn-success" onClick={() => this.submitAddUser()}>Add User</button>
                        <button type="button" className="btn btn-danger" onClick={() => this.props.toggleAddUser()}>Cancel</button>
                    </div>
                </div>
            </div>
        );
    }
}