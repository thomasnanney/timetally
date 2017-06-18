import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import ListItem from './ListItem';
import AddWorkspaceWizard from './workspaceManagerComponents/AddWorkspaceWizard';

class WorkspaceManager extends Component {

    constructor(props) {
        super(props);
        this.state ={
            addNewActive: false,
            workspaces: ['Workspace 1', 'Workspace 2', 'Workspace 3']
        };

        this.addWorkspace = this.addWorkspace.bind(this);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    addWorkspace(name){
        let workspaces = this.state.workspaces.slice();
        workspaces[this.state.workspaces.length] = name;
        this.setState({workspaces: workspaces});
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
                            <ListItem name={space} key={id}/>
                        )
                        :
                        <p>You do not have any workspaces...</p>
                    }
                </div>
                <div className="row">
                    <div className="col-xs-12 text-center large-container dark drop">
                        <AddWorkspaceWizard addWorkspace={this.addWorkspace} />
                    </div>
                </div>
            </div>
        );
    }
}

if(document.getElementById('workspaceManager')) {
    console.log("Manager present");
    ReactDOM.render(<WorkspaceManager/>, document.getElementById('workspaceManager'));
}