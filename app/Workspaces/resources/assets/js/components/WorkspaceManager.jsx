import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import ListItem from 'workspaces/WorkspaceManagerComponents/ListItem';
import AddWorkspaceWizard from 'workspaces/WorkspaceManagerComponents/AddWorkspaceWizard';
import SuccessNotification from 'core/SuccessNotification';
import ErrorNotification from 'core/ErrorNotification';

class WorkspaceManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
            workspaces: {},
            currentWorkspace: {},
        };

    }

    componentWillMount(){
        this.getWorkspaces();
        this.getCurrentWorkspace();
    };

    getCurrentWorkspace(){
        let self = this;
        axios.post('/users/getCurrentWorkspace')
            .then(function(response){
                self.setState({currentWorkspace: response.data});
            })
            .catch(function(response){
                console.log(response);
                alert("We were unable to retrieve your current workspace.  Please reload the page or contact your" +
                    " System Administrator.");
            });
    }

    getWorkspaces(){
        let self = this;
        axios.post('/users/getAllWorkspaces')
            .then(function(response){
                self.setState({workspaces: response.data});
            })
            .catch(function(response){
                console.log(response);
                alert("We were unable to retrieve all of your workspaces.  Please reload the page or contact your" +
                    " System Administrator.");
            });
    }

    makeWorkspaceActive(id){
        let self = this;

        axios.post('/users/makeWorkspaceActive/' + id)
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    self.getCurrentWorkspace();
                }
                if(response.stats == 401){
                    alert("There is an error with the workspace you selected, please refresh the page and try again\n");
                }
            }).catch(function(error){
                console.log(error);
                alert("We experienced an error updating your active workspace.  Please refresh the page and try" +
                    " again.");
        });
    }

    leaveWorkspace(workspace){
        let self = this;
        axios.post('/workspaces/leave/' + workspace.id)
            .then(function(response){
                if(response.status == 200){
                    self.showSuccess();
                    self.getWorkspaces();
                }
            }).catch(function(error){
                if(error.response.status == 400){
                    self.showError();
                }
                if(error.response.status == 403){
                    self.showError();
                }
                if(error.response.status == 409){
                    self.showError();
                    alert("You can not delete your active workspace.");
                }
        });
    }

    showSuccess(){
        let self = this;
        this.setState({showSuccess: true});
        window.setTimeout(function(){
            self.setState({showSuccess: false});
        }, 2000);
    }

    showError(){
        let self = this;
        this.setState({showError: true});
        window.setTimeout(function(){
            self.setState({showError: false});
        }, 2000);
    }

    render() {
        return (
            <div>
                <SuccessNotification show={this.state.showSuccess}/>
                <ErrorNotification show={this.state.showError}/>
                <h1>Workspaces</h1>
                <div className="list table workspace-list">
                    <div className="list-header table-row thick-border-bottom">
                        <div className="table-cell valign-bottom"></div>
                        <div className="table-cell valign-bottom">
                            Workspace
                        </div>
                        <div className="table-cell valign bottom">
                        </div>
                    </div>
                    {this.state.workspaces.length > 0 ?
                        this.state.workspaces.map((space, id) =>
                            <ListItem
                                workspace={space}
                                key={space.id}
                                active={(space.id == this.state.currentWorkspace.id)}
                                makeWorkspaceActive={this.makeWorkspaceActive.bind(this, space.id)}
                                leaveWorkspace={this.leaveWorkspace.bind(this)}
                            />
                        )
                        :
                        <p>You do not have any workspaces...</p>
                    }
                </div>
                <div className="row">
                    <div className="col-xs-12 text-center large-container dark drop">
                        <AddWorkspaceWizard updateWorkspaces={this.getWorkspaces.bind(this)} />
                    </div>
                </div>
            </div>
        );
    }
}

if(document.getElementById('workspaceManager')){
    ReactDOM.render(<WorkspaceManager />, document.getElementById('workspaceManager'));
}