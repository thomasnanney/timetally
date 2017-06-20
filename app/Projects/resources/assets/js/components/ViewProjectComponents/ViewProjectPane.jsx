import React, { Component } from 'react';
import Textarea from 'react-textarea-autosize';
//components imports

export default class ViewProjectPane extends Component {
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
                                            <label>Project Name:</label>
                                            <input type="text" className="tk-form-input" placeholder="Project Name..."></input>

                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            Public
                                            <label className="switch">
                                                <input type="checkbox"></input>
                                                <div className="slider round"></div>
                                            </label>
                                            Private
                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <Textarea className="tk-form-textarea" placeholder="Description..."/>
                                        </div>
                                    </div>
                                </div>
                            );
                        case 2:
                            return (
                                <div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Client</h1>
                                        <select className="tk-form-input">
                                            <option>Client 1</option>
                                            <option>Client 1</option>
                                            <option>Client 1</option>
                                            <option>Client 1</option>
                                        </select>
                                    </div>
                                    <br></br>
                                        <div className="row">
                                            <div className="col-xs-12">
                                                Fixed Price
                                                <label className="switch">
                                                    <input type="checkbox"></input>
                                                        <div className="slider round"></div>
                                                </label>
                                                Billed Hourly
                                            </div>
                                        </div>
                                    <br></br>
                                            <div className="row">
                                                <div className="col-xs-12">
                                                    <input type="text" className="tk-form-input" placeholder="$$$ Total Cost..."></input>
                                                </div>
                                            </div>
                                </div>
                            );
                        case 3:
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
                    }
                }) ()}
            </div>


        );
    }
}





