import React, { Component } from 'react';

//components imports
import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

export default class DropDownMenu extends Component {

    constructor (props) {
        super(props);
        this.state = {
            active: false
        }
        this.handleLinkClick = this.handleLinkClick.bind(this);
    }

    handleLinkClick () {
        this.refs.dropdown.hide();
    }

    setIcon(visibility){
        this.setState({active: visibility})
    }

    render(){

        return(
            <Dropdown ref="dropdown" className="full-width relative" onShow={this.setIcon.bind(this, true)} onHide={this.setIcon.bind(this, false)}>
                <DropdownTrigger className="full-width">
                    <i className="fa fa-bars clickable" aria-hidden="true"/>
                </DropdownTrigger>
                <DropdownContent>
                    <ul className="no-list-style no-margin no-padding text-center">
                        {this.props.items.map((item, id) =>
                            <li key={id} ><a href={item.link}>{item.name}</a></li>
                        )}
                    </ul>
                    <div className="tk-arrow"></div>
                </DropdownContent>
            </Dropdown>
        );
    }
}