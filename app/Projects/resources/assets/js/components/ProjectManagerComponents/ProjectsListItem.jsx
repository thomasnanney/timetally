import React, { Component } from 'react';

import DropDownMenu from 'core/DropDownMenu';

export default class ProjectsListItem extends Component{

    constructor(props){
        super(props);
        this.state = {
            isMenuActive: false
        };
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    toggleMenu(){
        this.setState((prevState, props) => ({
            isMenuActive: !prevState.isMenuActive,
        }));
    }

    render(){

        const menuItems = [
            {
                name: 'View',
                link: '/projects/edit/' + this.props.project.id
            }
        ];

        return (
            <div className="thin-border-bottom table-row">
                <div className="table-cell menu-icon-cell valign-bottom">
                    <DropDownMenu items={menuItems}/>
                </div>
                <div className="table-cell valign-bottom">{this.props.project.title}
                    <span className={"badge tk-badge tk-badge-" + this.props.project.scope}>{this.props.project.scope}</span>
                </div>
                <div className="table-cell valign-bottom">{this.props.project.clientName}</div>
                <div className="table-cell valign-bottom">{this.props.project.workspaceTitle}<i className="fa fa-trash pull-right error clickable" aria-hidden="true" onClick={() => this.props.removeItem(this.props.project)}/></div>
            </div>
        );
    }
}