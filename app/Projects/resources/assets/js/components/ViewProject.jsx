import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports

import ViewProjectPane from 'projects/ViewProjectComponents/ViewProjectPane'

class ViewProject extends Component {

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
                <div className="tile raise">
                    <div className="row">
                        <div className="col-xs-12">
                            <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                                <li className={"tab " + (this.state.activeView == 1 ? 'active': '')} onClick={() => this.makeTabActive(1)}>General</li>
                                <li className={"tab " + (this.state.activeView == 2 ? 'active': '')} onClick={() => this.makeTabActive(2)}>Details</li>
                                <li className={"tab " + (this.state.activeView == 3 ? 'active': '')} onClick={() => this.makeTabActive(3)}>Users</li>
                            </ul>
                        </div>
                    </div>
                    <div className="pane-container">
                        <ViewProjectPane activeView={this.state.activeView} />
                    </div>
                </div>
            </div>
        );
    }
}

if(document.getElementById('viewProject')){
    console.log("view project");
    ReactDOM.render(<ViewProject/>, document.getElementById('viewProject'));
}