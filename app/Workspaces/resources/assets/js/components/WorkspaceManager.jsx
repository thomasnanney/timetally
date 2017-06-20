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

        const  workspaces = [
            {
                name: 'Workspace 1',
                link: '/workspaces/view/1'
            },
            {
                name: 'Workspace 2',
                link: '/workspaces/view/1'
            },
            {
                name: 'Workspace 3',
                link: '/workspaces/view/1'
            },
        ];

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
                    {workspaces.length > 0 ?
                        workspaces.map((space, id) =>
                            <ListItem workspace={space} key={id}/>
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

if(document.getElementById('workspaceManager')){
    console.log("manager present");
    ReactDOM.render(<WorkspaceManager />, document.getElementById('workspaceManager'));
}