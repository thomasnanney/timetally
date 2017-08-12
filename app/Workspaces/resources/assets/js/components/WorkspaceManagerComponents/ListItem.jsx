import React, { Component } from 'react';

//components imports
import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

export default class ListItem extends Component {

    constructor(props) {
        super(props);

        this.handleLinkClick = this.handleLinkClick.bind(this);
        this.leaveWorkspace = this.leaveWorkspace.bind(this);
    }

    handleLinkClick () {
        this.refs.dropdown.hide();
    }

    makeWorkspaceActive(){
        this.handleLinkClick();
        this.props.makeWorkspaceActive();
    }

    leaveWorkspace(e){
        e.preventDefault();
        this.props.leaveWorkspace(this.props.workspace);
    }

    render() {

        return (
            <div className="thin-border-bottom table-row">
                <div className="table-cell menu-icon-cell valign-bottom">
                    <Dropdown ref="dropdown" className="full-width relative">
                        <DropdownTrigger className="full-width">
                            <i className="fa fa-bars clickable" aria-hidden="true"/>
                        </DropdownTrigger>
                        <DropdownContent>
                            <ul className="no-list-style no-margin no-padding text-center">
                                <li><a className="no-link-style" href={"/workspaces/view/" + this.props.workspace.id}>View</a></li>
                                {
                                    !this.props.active &&
                                        <li onClick={this.makeWorkspaceActive.bind(this)} className="clickable">Make Active Workspace</li>
                                }
                                <li onClick={this.leaveWorkspace}><a className="no-link-style" href="#">Leave Workspace</a></li>
                            </ul>
                            <div className="tk-arrow"></div>
                        </DropdownContent>
                    </Dropdown>
                </div>
                <div className="table-cell valign-bottom">
                    {this.props.workspace.name}
                    {
                        this.props.active &&
                        <span className="badge tk-badge tk-badge-active">Active</span>
                    }
                </div>
                <div className="table-cell valign-bottom"></div>
            </div>
        );
    }
}