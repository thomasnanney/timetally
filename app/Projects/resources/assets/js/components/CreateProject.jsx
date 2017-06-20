import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class CreateProject extends Component{

    constructor(props){
        super(props);
        this.state = {
            step: 1,
            users: []
        }
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    nextStep(){
        this.setState((prevState, props) => ({
            step: prevState.step + 1
        }));
    }

    prevStep(){
        this.setState((prevState, props) => ({
            step: prevState.step - 1
        }));
    }

    createProject(){
        alert("You created a project!");
    }

    addUserField(){
        this.setState((prevState, props) => ({
            users: prevState.users.concat(['']),
        }))
    };

    updateUserName(id, evt){
        let users = this.state.users.slice();
        users[id] = evt.target.value;
        this.setState({users: users});
    }

    render(){
        return(
            <div className="tile raise">
                <div className="pane-container">
                    {(() => {
                        switch (this.state.step) {
                            case 1:
                                return (
                                    <div className="pane medium-container margin-center">
                                        <div>
                                            <h1>Project Name</h1>
                                            <input type="text" className="tk-form-input" placeholder="Project Name..."></input>
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
                                                <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right" aria-hidden="true">&nbsp;</i></a>
                                            </div>
                                        </div>
                                    </div>
                                );
                            case 2:
                                return (<div className="pane medium-container margin-center">
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
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right"
                                                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>);
                            case 3:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Add Users</h1>
                                        {
                                            this.state.users.map((user, id) => (
                                                <input type="text" className="tk-form-input" placeholder="User's Email..." value={this.state.users[id]} onChange={this.updateUserName.bind(this, id)}></input>
                                            ))
                                        }
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12 text-center">
                                            <button onClick={() => this.addUserField()} className="btn tk-btn">Add User</button>
                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.nextStep()}>Next <i className="fa fa-chevron-right"
                                                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>);
                            case 4:
                                return (<div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Project Details</h1>
                                        <textarea className="tk-form-textarea" placeholder="Project Description..."></textarea>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <a href="#" className="no-link-style" onClick={() => this.prevStep()}><i className="fa fa-chevron-left" aria-hidden="true"></i>
                                                Back</a>
                                            <a href="#" className="no-link-style pull-right" onClick={() => this.createProject()}>Finish <i className="fa fa-chevron-right"
                                                                                                       aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>);
                        }
                    }) ()}
                </div>
            </div>
        );
    }
}

if(document.getElementById('createProject')){
    ReactDOM.render(<CreateProject/>, document.getElementById('createProject'));
}