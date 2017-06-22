import React, { Component } from 'react';
import Textarea from 'react-textarea-autosize';
//components imports

export default class ViewProjectPane extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }


    onFieldChange(event){
        this.props.updateInput(event.target.name, event.target.value);
    }

    onCheckboxChange(event){
        let name = event.target.name;
        let value = event.target.checked;
        if(name == 'scope'){
            if(value){
                this.props.updateInput(name, 'private');
            }else{
                this.props.updateInput(name, 'public');
            }
        }
        if(name == 'billableType'){
            if(value){
                this.props.updateInput(name, 'hourly');
            }else{
                this.props.updateInput(name, 'fixed');
            }
        }
        if(name == 'billableHourlyType'){
            if(value){
                this.props.updateInput(name, 'employee');
            }else{
                this.props.updateInput(name, 'project');
            }
        }
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
                                            <input
                                                type="text"
                                                name="title"
                                                className="tk-form-input"
                                                placeholder="Project Name..."
                                                value={this.props.project.title}
                                                onChange={this.onFieldChange.bind(this)}
                                            />

                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            Public
                                            <label className="switch">
                                                <input
                                                    type="checkbox"
                                                    checked = {this.props.project.scope == "private"}
                                                    name="scope"
                                                    onChange={this.onCheckboxChange.bind(this)}
                                                />
                                                <div className="slider round"></div>
                                            </label>
                                            Private
                                        </div>
                                    </div>
                                    <br></br>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            <Textarea
                                                className="tk-form-textarea"
                                                name="description"
                                                placeholder="Description..."
                                                value={this.props.project.description}
                                                onChange={this.onFieldChange.bind(this)}
                                            />
                                        </div>
                                    </div>
                                </div>
                            );
                        case 2:
                            return (
                                <div className="pane medium-container margin-center">
                                    <div>
                                        <h1>Client</h1>
                                        <select className="tk-form-input" value={this.props.project.client} onChange={this.onFieldChange.bind(this)} name="clientID">
                                            {
                                                this.props.clients.length > 0
                                                ?
                                                    this.props.clients.map((client) =>
                                                        <option value={client.id} key={client.id}>{client.name}</option>
                                                    )
                                                    :
                                                    <option>Add a client</option>
                                            }
                                        </select>
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            Fixed Price
                                            <label className="switch">
                                                <input
                                                    type="checkbox"
                                                    name="billableType"
                                                    checked = {this.props.project.billableType == 'hourly'}
                                                    onChange={this.onCheckboxChange.bind(this)}
                                                />
                                                    <div className="slider round"></div>
                                            </label>
                                            Billed Hourly
                                        </div>
                                    </div>
                                    <br/>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            {
                                                this.props.project.billableType == 'fixed'
                                                    ?
                                                    <input
                                                        type="text"
                                                        name="projectedRevenue"
                                                        className="tk-form-input"
                                                        placeholder="$$$ Total Cost..."
                                                        value={this.props.project.projectedRevenue}
                                                        onChange={this.onFieldChange.bind(this)}
                                                    />
                                                    :
                                                    <div>
                                                        Project Hourly Rate
                                                        <label className="switch">
                                                            <input
                                                                type="checkbox"
                                                                name="billableHourlyType"
                                                                checked={this.props.project.billableHourlyType == 'employee'}
                                                                onChange={this.onCheckboxChange.bind(this)}
                                                            />
                                                            <div className="slider round"></div>
                                                        </label>
                                                        Employee Hourly Rate
                                                    </div>
                                            }
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-xs-12">
                                            {
                                                this.props.project.billableHourlyType == 'project' && this.props.project.billableType == 'hourly'
                                                    ?
                                                    <input
                                                        type="text"
                                                        name="billableRate"
                                                        className="tk-form-input"
                                                        placeholder="$$$ Hourly Rate"
                                                        value={this.props.project.billableRate}
                                                        onChange={this.onFieldChange.bind(this)}
                                                    />
                                                    :

                                                    ''
                                            }
                                        </div>
                                    </div>
                                </div>
                            );
                        case 3:
                            return (
                                <div className="pane medium-container margin-center">
                                    <ul className="no-list-style no-margin no-padding list">
                                        {
                                            this.props.users.map((user) =>
                                                <li><a href="/users">{user.name}</a></li>
                                            )
                                        }
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





