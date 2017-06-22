import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports

import ViewClientPane from 'clients/ViewClientComponents/ViewClientPane'

class ViewClient extends Component {

    constructor(props) {
        super(props);
        this.state ={
            activeView: 1
        };
    }

    componentDidMount() {

    }

    componentWillMount(){

    }

    componentWillUnmount() {

    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }
    render() {

        const tabs = [
            'General',
            'Details',
            'Projects'
        ];

        console.log(tk.client);

        return (
            <div className="tile raise">
                <div className="row">
                    <div className="col-xs-12">
                        <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                            {
                                tabs.map((tab, id) =>
                                    <li className={"tab " + (this.state.activeView == id+1 ? 'active': '')} onClick={() => this.makeTabActive(id+1)} key={id}>{tab}</li>
                                )
                            }
                        </ul>
                    </div>
                </div>
                <div className="pane-container">
                    <ViewClientPane activeView={this.state.activeView} />
                </div>
            </div>
        );
    }
}

if(document.getElementById('viewClient')){
    ReactDOM.render(<ViewClient />, document.getElementById('viewClient'));
}