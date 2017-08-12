import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import WorkspaceSettingsPane from 'workspaces/ViewWorkspaceComponents/WorkspaceSettingsPane';
import SuccessNotification from 'core/SuccessNotification';
import ErrorNotification from 'core/ErrorNotification';

class WorkspaceSettings extends Component {

    constructor(props) {
        super(props);
        this.state ={
            activeView: 1,
            showSuccess: false,
            showError: false,
        };
    }

    componentDidMount() {

    }

    componentWillUnmount() {

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

    render() {

        return (
            <div>
                <SuccessNotification show={this.state.showSuccess}/>
                <ErrorNotification show={this.state.showError}/>
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
                        <WorkspaceSettingsPane activeView={this.state.activeView} showSuccess={this.showSuccess.bind(this)} showError={this.showError.bind(this)}/>
                    </div>
                </div>
            </div>
        );
    }
}

if(document.getElementById('workspaceSettings')){
    console.log("settings present");
    ReactDOM.render(<WorkspaceSettings />, document.getElementById('workspaceSettings'));
}