import React, {Component} from 'react';

import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

export default class DropDownCheckList extends Component{

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
                    <div className="search-input full-width">
                        {this.props.triggerName}
                        {
                            (this.state.active)
                                ? <i className="fa fa-chevron-up pull-right" aria-hidden="true"/>
                                : <i className="fa fa-chevron-down pull-right" aria-hidden="true"/>
                        }
                    </div>
                </DropdownTrigger>
                <DropdownContent>
                    <ul className="no-list-style no-padding list">
                        {
                            this.props.data.map((item, id) => (
                                <li key={item.value} className="table no-padding no-margin">
                                    <div className="table-cell width-20 valign-middle no-padding">
                                        <label className="switch">
                                            <input type="checkbox"
                                                   name={id}
                                                   value={item.value}
                                                   checked={item.selected}
                                                   onChange={this.props.updateInput}
                                            />
                                            <div className="slider round"></div>
                                        </label>
                                    </div>
                                    <div className="table-cell width-80">
                                        {item.title}
                                    </div>
                                </li>
                            ))
                        }
                    </ul>
                    <div className="tk-arrow"></div>
                </DropdownContent>
            </Dropdown>
        );
    }
}
