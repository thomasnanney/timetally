import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import WorkspaceSettingsPane from 'workspaces/ViewWorkspaceComponents/WorkspaceSettingsPane';

class WorkspaceSettings extends Component {

    constructor(props) {
        super(props);
        this.state ={
            activeView: 1
        };
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }
    render() {

        return (
            <div className="tile raise">
                <div className="row">
                    <div className="col-xs-12">
                        <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                            <li className={"tab " + (this.state.activeView == 1 ? 'active': '')} onClick={() => this.makeTabActive(1)}>Settings</li>
                            <li className={"tab " + (this.state.activeView == 2 ? 'active': '')} onClick={() => this.makeTabActive(2)}>Users</li>
                            <li className={"tab " + (this.state.activeView == 3 ? 'active': '')} onClick={() => this.makeTabActive(3)}>Projects</li>
                            <li className={"tab " + (this.state.activeView == 4 ? 'active': '')} onClick={() => this.makeTabActive(4)}>Clients</li>
                        </ul>
                    </div>
                </div>
                <div className="pane-container">
                    <WorkspaceSettingsPane activeView={this.state.activeView} />
                </div>
            </div>
        );
    }
}

if(document.getElementById('workspaceSettings')){
    console.log("settings present");
    ReactDOM.render(<WorkspaceSettings />, document.getElementById('workspaceSettings'));
}