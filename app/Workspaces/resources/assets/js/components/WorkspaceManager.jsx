import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import ListItem from 'workspaces/WorkspaceManagerComponents/ListItem';
import AddWorkspaceWizard from 'workspaces/WorkspaceManagerComponents/AddWorkspaceWizard';

class WorkspaceManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
            workspaces: {}
        };

    }

    componentWillMount(){
        this.getWorkspaces();
    };

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

    render() {

        return (
            <div>
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
                            <ListItem workspace={space} key={space.id}/>
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
    console.log("manager present");
    ReactDOM.render(<WorkspaceManager />, document.getElementById('workspaceManager'));
}