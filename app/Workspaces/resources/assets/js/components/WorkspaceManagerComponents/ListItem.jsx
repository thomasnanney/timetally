import React, { Component } from 'react';

//components imports
import DropDownMenu from 'core/DropDownMenu';

export default class ListItem extends Component {

    constructor(props) {
        super(props);
        this.state = {
            active: false,
        };

        this.handleClick = this.handleClick.bind(this);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    handleClick(){
        this.setState((prevState, props) => ({
            active: !prevState.active,
        }));
    }

    render() {
        const menuItems = [
            {
                name: 'Settings',
                link: '/workspaces/edit/' + this.props.workspace.id
            },
            {
                name: 'Leave',
                link: '/workspaces/removeUser'
            }
        ];

        return (
            <div className="thin-border-bottom table-row">
                <div className={"table-cell menu-icon-cell valign-bottom tk-dropdown-container relative " + (this.state.active ? "active " : "")}>
                    <i className="fa fa-bars clickable" aria-hidden="true" onClick={this.handleClick}/>
                    <DropDownMenu items={menuItems} align="align-left"/>
                </div>
                <div className="table-cell valign-bottom">{this.props.workspace.title}</div>
                <div className="table-cell valign-bottom"></div>
            </div>
        );
    }
}