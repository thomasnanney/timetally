import React, { Component } from 'react';

//components imports
import DropDownMenu from 'core/DropDownMenu';

export default class ListItem extends Component {

    constructor(props) {
        super(props);
    }

    render() {
        const menuItems = [
            {
                name: 'Settings',
                link: '/workspaces/edit/' + this.props.workspace.id
            },
            // {
            //     name: 'Leave',
            //     link: '/workspaces/removeUser'
            // }
        ];

        return (
            <div className="thin-border-bottom table-row">
                <div className="table-cell menu-icon-cell valign-bottom">
                    <DropDownMenu items={menuItems}/>
                </div>
                <div className="table-cell valign-bottom">{this.props.workspace.name}</div>
                <div className="table-cell valign-bottom"></div>
            </div>
        );
    }
}