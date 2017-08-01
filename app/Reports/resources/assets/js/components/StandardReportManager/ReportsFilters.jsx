import React, {Component} from 'react';

import DropDownCheckList from 'core/DropDownCheckList';

export default class ReportFilters extends Component{
    constructor(props){
        super(props);
        this.state = {
            employeesMenu: false,
            clientsMenu: false,
            projectsMenu: false,
            clients: [],
            users: [],
            projects: [],
        }
    }

    componentWillMount(){
        this.getAllUsers();
        this.getAllClients();
        this.getAllProjects();
    }

    getAllClients(){
        let self = this;
        axios.post('/workspaces/getAllClients')
            .then(function(response){
                let newState = self.state;
                newState.clients = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    getAllUsers(){
        let self = this;
        axios.post('/workspaces/getAllUsers')
            .then(function(response){
                let newState = self.state;
                newState.users = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    getAllProjects(){
        let self = this;
        axios.post('/workspaces/getAllProjects')
            .then(function(response){
                let newState = self.state;
                newState.projects = response.data;
                self.setState(newState);
            })
            .catch(function(response){
                console.log(response);
            })
    }

    toggleMenu(menu){
        let newState = this.state;
        newState[menu] = !this.state[menu];
        this.setState(newState);
    }

    updateInput(type, ele){
        console.log(type);
        console.log(ele.target.name);
        console.log(ele.target.checked);
        console.log(this.state);
        let newState = this.state;
        newState[type][ele.target.name].selected = ele.target.checked;
        this.setState(newState);
        this.props.updateFilters(type, ele.target.name, ele.target.checked);
    }

    render(){

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12">
                        <div className="drop search-bar">
                            <div className="row">
                                <div className="col-xs-12 col-sm-4 col-md-2 border-right">
                                    <div className="search-input full-width" onClick={() => this.toggleMenu('employeesMenu')}>Employees
                                        {
                                            this.state.employeesMenu
                                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                                        }
                                    </div>
                                    <DropDownCheckList align="right" show={this.state.employeesMenu} collapse={this.toggleMenu.bind(this, 'employeesMenu')} updateInput={this.updateInput.bind(this, 'users')} data={this.state.users}/>
                                </div>
                                <div className="col-xs-12 col-sm-4 col-md-2 border-right">
                                    <div className="search-input full-width" onClick={() => this.toggleMenu('clientsMenu')}>Clients
                                        {
                                            this.state.clientsMenu
                                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                                        }</div>
                                    <DropDownCheckList align="right" show={this.state.clientsMenu} collapse={this.toggleMenu.bind(this, 'clientsMenu')} updateInput={this.updateInput.bind(this, 'clients')} data={this.state.clients}/>
                                </div>
                                <div className="col-xs-12 col-sm-4 col-md-2 border-right">
                                    <div className="search-input full-width" onClick={() => this.toggleMenu('projectsMenu')}>Projects
                                        {
                                            this.state.projectsMenu
                                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                                        }
                                    </div>
                                    <DropDownCheckList align="right" show={this.state.projectsMenu} collapse={this.toggleMenu.bind(this, 'projectsMenu')} updateInput={this.updateInput.bind(this, 'projects')} data={this.state.projects}/>
                                </div>
                                <div className="col-xs-12 col-md-4">
                                    <input type="search" className="search-input"/>
                                </div>
                                <div className="col-xs-12 col-md-2 no-padding">
                                    <button className="tk-btn-success search-input full-width" onClick={() => this.props.updateReport()}>Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row filter-box">
                    {/*Show current filters box*/}
                </div>
            </div>
        )
    }
}