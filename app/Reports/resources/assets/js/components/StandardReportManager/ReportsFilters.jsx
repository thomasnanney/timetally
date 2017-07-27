import React, {Component} from 'react';

import DropDownCheckList from 'core/DropDownCheckList';

export default class ReportFilters extends Component{
    constructor(props){
        super(props);
        this.state = {
            employeesMenu: false,
            clientsMenu: false,
            projectsMenu: false
        }
    }

    componentWillMount(){
        let data = [
            {
                value: 0,
                title: 'Option 1',
                selected: false,
            },
            {
                value: 1,
                title: 'Option 2',
                selected: false,
            },
            {
                value: 2,
                title: 'Option 3',
                selected: false,
            },
            {
                value: 3,
                title: 'Option 4',
                selected: false,
            },
            {
                value: 4,
                title: 'Option 5',
                selected: false,
            },
        ];

        this.setState({data: data});
    }

    toggleMenu(menu){
        let newState = this.state;
        newState[menu] = !this.state[menu];
        this.setState(newState);
    }

    updateInput(type, ele){
        let newState = this.state;
        newState.data[ele.target.name].selected = ele.target.checked;
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
                                    <DropDownCheckList align="right" show={this.state.employeesMenu} collapse={this.toggleMenu.bind(this, 'employeesMenu')} updateInput={this.updateInput.bind(this, 'users')} data={this.state.data}/>
                                </div>
                                <div className="col-xs-12 col-sm-4 col-md-2 border-right">
                                    <div className="search-input full-width" onClick={() => this.toggleMenu('clientsMenu')}>Clients
                                        {
                                            this.state.clientsMenu
                                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                                        }</div>
                                    <DropDownCheckList align="right" show={this.state.clientsMenu} collapse={this.toggleMenu.bind(this, 'clientsMenu')} updateInput={this.updateInput.bind(this, 'clients')} data={this.state.data}/>
                                </div>
                                <div className="col-xs-12 col-sm-4 col-md-2 border-right">
                                    <div className="search-input full-width" onClick={() => this.toggleMenu('projectsMenu')}>Projects
                                        {
                                            this.state.projectsMenu
                                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                                        }
                                    </div>
                                    <DropDownCheckList align="right" show={this.state.projectsMenu} collapse={this.toggleMenu.bind(this, 'projectsMenu')} updateInput={this.updateInput.bind(this, 'projects')} data={this.state.data}/>
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