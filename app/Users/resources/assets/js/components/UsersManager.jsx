import React, { Component } from 'react';
import ReactDOM from 'react-dom';

// import SearchBar from 'projects/ProjectManagerComponents/SearchBar'
import Modal from 'core/Modal';

class UsersManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            users: [],
            promptDelete: false,
            promptDeleteUser: null,
            promptToggleAdmin: false,
            promptToggleAdminUser: null
        }
    }

    componentDidMount(){

    }

    componentWillMount(){
        this.getUsers();
    }

    componentWillUnmount(){

    }

    getUsers(){
        let self = this;
        axios.post('/workspaces/getAllUsers', {
            raw: true
        })
            .then(function(response){
                self.setState({users : response.data});
            })
            .catch(function(error){
                console.log(error);
                alert('We were unable to retrieve the users for your current workspace.  Try reloading the page, or' +
                    ' contact your System' +
                    ' Administrator');
            });
    }

    promptDelete(user){
        this.setState({promptDelete: true});
        this.setState({promptDeleteUser: user});
    }

    cancelDelete(){
        this.setState({promptDelete: false});
        this.setState({promptDeleteUser: null});
    }

    removeUser(){
        let self = this;
        axios.post('/workspaces/deleteUser/' + self.state.promptDeleteUser.id)
            .then(function(response){
                if(response.status == 'fail'){
                    alert(response.messages[0]);
                }
            })
            .catch(function(error){
                console.log(error);
                alert("We experienced an error while attempting to delete your project.  PLease reload the page and" +
                    " try again.");
            });

        this.getUsers();
        this.setState({promptDelete: false, promptDeleteProject: null});

    }

    promptToggleAdmin(user){
        this.setState({promptToggleAdmin: true});
        this.setState({promptToggleAdminUser: user});
    }

    toggleAdmin(){
        let url = null;
        if(this.state.promptToggleAdminUser.pivot.admin){
            url = '/workspaces/removeAdmin/'+this.state.promptToggleAdminUser.id;
        }else{
            url = '/workspaces/addAdmin/'+this.state.promptToggleAdminUser.id;
        }

        let self = this;
        axios.post(url).then(function(response){
            if(response.status == 200){
                self.cancelToggleAdmin();
                alert("Users privileges successfully updated");
                self.getUsers();
            }
        }).catch(function(error){
            console.log(error);
            alert("We experienced an error updating the privileges, please refresh the page and try again.");
        });
    }

    cancelToggleAdmin(){
        this.setState({promptToggleAdmin: false});
        this.setState({promptToggleAdminUser: null});
    }

    render(){

        let header = null;
        let body = null;
        if(this.state.promptDelete) {
            header = "Are you sure?";
            body = "Are you sure you want to delete  " + this.state.promptDeleteUser.title;
        }

        let adminHeader = null;
        let adminBody = null;
        if(this.state.promptToggleAdmin) {
            adminHeader = "Are you sure?";
            if(this.state.promptToggleAdminUser.pivot.admin){
                adminBody = "Are you sure you want to remove " + this.state.promptToggleAdminUser.name + " as an" +
                    " administrator?";
            }else{
                adminBody = "Are you sure you want to make " + this.state.promptToggleAdminUser.name + " an" +
                    " administrator?";
            }
        }

        return (
            <div className="log-container">
                <div className="row">
                    <div className="col-xs-12">
                        <span className="tk-header">Users</span>
                    </div>
                </div>
                <br/>
                <ul>
                    <li>
                        <div className="row">
                            <div className="col-xs-12 col-md-6">
                                Name:
                            </div>
                            <div className="col-xs-4 col-md-3">
                                Level:
                            </div>
                            <div className="col-xs-4 col-md-3">
                                Email:
                            </div>
                        </div>
                    </li>
                    {
                        this.state.users.map((user, id) => (
                            <li key={id}>
                                <div className="row">
                                    <div className="col-xs-12 col-md-6">
                                        {user.name}
                                    </div>
                                    <div className="col-xs-4 col-md-3">
                                        {
                                            user.pivot.admin
                                            ?
                                                <span className="label label-success clickable" onClick={this.promptToggleAdmin.bind(this, user)}>Admin</span>
                                            :
                                                <span className="label label-default clickable" onClick={this.promptToggleAdmin.bind(this, user)}>Regular</span>
                                        }
                                    </div>
                                    <div className="col-xs-4 col-md-3">
                                        {user.email}
                                    </div>
                                </div>
                            </li>
                        ))
                    }
                </ul>

                {this.state.promptDelete &&
                <Modal show={true} header={header} body={body} onConfirm={this.removeUser.bind(this)} onClose={this.cancelDelete.bind(this)} />
                }
                {this.state.promptToggleAdmin &&
                <Modal show={true} header={adminHeader} body={adminBody} onConfirm={this.toggleAdmin.bind(this)} onClose={this.cancelToggleAdmin.bind(this)} />
                }
            </div>
        );
    }
}

if(document.getElementById('userManager')){
    ReactDOM.render(<UsersManager/>, document.getElementById('userManager'));
}