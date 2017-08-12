import React, {Component} from 'react';

import DayPicker from 'react-day-picker';
import 'react-day-picker/lib/style.css';

import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

import DateFormat from 'dateformat';

export default class DropDownDatePicker extends Component{

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

    handleDayClick(day){
        this.props.updateInput(day);
    }

    render(){

        console.log(this.props.date);

        return(
            <Dropdown ref="dropdown" className="full-width relative" onShow={this.setIcon.bind(this, true)} onHide={this.setIcon.bind(this, false)}>
                <DropdownTrigger className="full-width">
                    <label>{this.props.triggerLabel}</label>
                    <input type="text" value={this.props.date ? DateFormat(this.props.date, "mm/dd/yy") : ''} className="tk-timer-input inline-block width-auto" readOnly={true}/>
                </DropdownTrigger>
                <DropdownContent>
                    <DayPicker onDayClick={this.handleDayClick.bind(this)} selectedDays={this.props.date ? DateFormat(this.props.date, "mm/dd/yy") : ''}/>
                    <div className="tk-arrow"></div>
                </DropdownContent>
            </Dropdown>
        );
    }

}
