import React, { Component } from 'react';

//components imports

export default class WorkspaceSettingsPane extends Component {
    constructor(props) {
        super(props);
        this.state ={

        };
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    render() {

        return (
            <div>
            {(() => {
                switch(this.props.activeView){
                    case 1:
                        return (
                            <div className="pane medium-container margin-center">
                                <div className="row">
                                    <div className="col-xs-12 ">
                                        <label>Workspace Name:</label>
                                        <input type="text" className="tk-form-input"></input>
                                    </div>
                                </div>
                            </div>
                        );
                    case 2:
                        return (
                            <div className="pane medium-container margin-center">
                                <ul className="no-list-style no-margin no-padding list">
                                    <li>User 1</li>
                                    <li>User 1</li>
                                    <li>User 1</li>
                                    <li>User 1</li>
                                </ul>
                                <div className="row">
                                    <div className="col-xs-12 text-center">
                                        <a href="#">+ Add User</a>
                                    </div>
                                </div>
                            </div>
                        );
                    case 3:
                        return (
                            <div className="pane medium-container margin-center">
                                <ul className="no-list-style no-margin no-padding list">
                                    <li>Project 1</li>
                                    <li>Project 1</li>
                                    <li>Project 1</li>
                                    <li>Project 1</li>
                                </ul>
                                <div className="row">
                                    <div className="col-xs-12 text-center">
                                        <a href="#">+ Add Project</a>
                                    </div>
                                </div>
                            </div>
                        );
                    case 4:
                        return (
                            <div className="pane medium-container margin-center">
                                <ul className="no-list-style no-margin no-padding list">
                                    <li>Client 1</li>
                                    <li>Client 1</li>
                                    <li>Client 1</li>
                                    <li>Client 1</li>
                                </ul>
                                <div className="row">
                                    <div className="col-xs-12 text-center">
                                        <a href="#">+ Add Client</a>
                                    </div>
                                </div>
                            </div>
                        );
                }
            }) ()}
            </div>


        );
    }
}





