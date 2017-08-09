import React, {Component} from 'react';

import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

export default class DropDownSelect extends Component{

    constructor (props) {
        super(props);
        this.state = {
            active: false
        }
    }

    handleClick () {
        this.refs.dropdown.hide();
    }

    setIcon(visibility){
        this.setState({active: visibility})
    }

    updateInput(item){
        let evt ={
            target : {}
        };
        evt.target.name = this.props.name;
        evt.target.value = item;
        evt.type = "select";
        this.props.updateInput(evt);
        this.handleClick();
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
                <DropdownContent className="scroll">
                    <ul className="no-list-style no-padding list select-list">
                        {
                            this.props.data.map((item, id) => (
                                <li
                                    key={id}
                                    className="table no-padding no-margin clickable"
                                    value={item.value}
                                    onClick={() => this.updateInput(item)}
                                >
                                    {item.title}
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
