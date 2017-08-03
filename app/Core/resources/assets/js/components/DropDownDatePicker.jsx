import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import DayPicker from 'react-day-picker';
import 'react-day-picker/lib/style.css';

export default class DropDownDatePicker extends Component{

    constructor(props){
        super(props);
        this.state = {
            selectedDay: new Date(),
        }
    }

    componentWillMount(){

    }

    componentDidMount(){

    }

    componentDidUpdate(){
        if(this.props.show){
            ReactDOM.findDOMNode(this).focus();
        }
    }

    handleDayClick(day){
        this.props.updateInput(day);
    }

    handleBlur(e) {
        let self = this;
        let currentTarget = e.currentTarget;
        setTimeout(function() {
            if (!currentTarget.contains(document.activeElement)) {
                self.props.collapse();
            }
        }, 0);
    }

    render(){
        return(
            <div tabIndex="0" onBlur={this.handleBlur.bind(this)} ref="self">
                <div className={"date-picker tk-dropdown tk-root " + this.props.align + " " + (this.props.show ? 'active' : '')}>
                    <div className="row">
                        <div className="col-xs-12">
                            <DayPicker onDayClick={this.handleDayClick.bind(this)} selectedDays={this.props.date}/>
                        </div>
                    </div>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}
