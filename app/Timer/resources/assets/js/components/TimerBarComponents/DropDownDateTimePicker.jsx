import React, {Component} from 'react';
import Timepicker from 'react-timepicker';
import DayPicker from 'react-day-picker';
import 'react-day-picker/lib/style.css';
import Dropdown, { DropdownTrigger, DropdownContent } from 'react-simple-dropdown';
import 'react-simple-dropdown/styles/Dropdown.css';

import DateFormat from 'dateformat';

export default class DropDownDateTimePicker extends Component{

    constructor(props){
        super(props);
        this.state = {
            selectedTime: new Date()
        }
    }

    componentWillMount(){

    }

    componentWillMount(){

    }

    handleDayClick(day){
        let current = new Date(this.state.selectedTime);
        let newDay = new Date(day);
        newDay.setHours(current.getHours(), current.getMinutes());
        this.setState({selectedTime: newDay}, function(){
            this.updateInput();
        });
    }

    handleTimeClick(hour, minute){
        let current = new Date(this.state.selectedTime);
        if(hour){
            if(current.getHours() > 11){
                current.setHours(hour + 12)
                this.setState({selectedTime: current}, function(){
                    this.updateInput();
                });
            }else{
                current.setHours(hour)
                this.setState({selectedTime: current}, function(){
                    this.updateInput();
                });
            }
        }
        if(minute){
            current.setMinutes(minute)
            this.setState({selectedTime: current}, function(){
                this.updateInput();
            });
        }
    }

    handleTimeOfDayClick(event){
        let value = event.target.value;
        let current = new Date(this.state.selectedTime);
        if(value == 'AM' && current.getHours() > 11){
            current.setHours(current.getHours()-12)
            this.setState({selectedTime: current}, function(){
                this.updateInput();
            });
        }
        if(value == 'PM' && current.getHours() <= 11){
            current.setHours(current.getHours()+12)
            this.setState({selectedTime: current}, function(){
                this.updateInput();
            });
        }
    }

    updateInput(){
        let evt = {
            target: {}
        };
        evt.target.name = this.props.name;
        evt.target.type = 'text';
        evt.target.value = new Date(this.state.selectedTime);
        this.props.updateInput(evt);
    }

    render(){

        return(
            <Dropdown ref="dropdown" className="full-width relative">
                <DropdownTrigger className="full-width">
                    <input type="text" value={this.props.time ? DateFormat(this.props.time, "mm/dd/yy h:MM TT") : ''} className="timer-element tk-timer-input" placeholder={this.props.placeholder}/>
                </DropdownTrigger>
                <DropdownContent>
                    <div className="row">
                        <div className="">
                            <DayPicker onDayClick={this.handleDayClick.bind(this)} selectedDays={new Date(this.state.selectedTime)} className="block"/>
                        </div>
                        <div className="text-center">
                            <Timepicker
                                size={300}
                                radius={80}
                                militaryTime={false}
                                hours={new Date(this.state.selectedTime).getHours() > 11 ? new Date(this.state.selectedTime).getHours() -11 : new Date(this.state.selectedTime).getHours() + 1}
                                minutes={new Date(this.state.selectedTime).getMinutes()}
                                onChange={this.handleTimeClick.bind(this)}
                            />
                            <div className="row">
                                <div className="col-xs-12 text-center">
                                    <div className="btn-group" role="group">
                                        <button type="button" className={"btn btn-primary " + (new Date(this.state.selectedTime).getHours() <= 11 ? 'active' : '')} value="AM" onClick={(e) => this.handleTimeOfDayClick(e)}>AM</button>
                                        <button type="button" className={"btn btn-primary " + (new Date(this.state.selectedTime).getHours() > 11  ? 'active' : '')} value="PM" onClick={(e) => this.handleTimeOfDayClick(e)}>PM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="tk-arrow"></div>
                </DropdownContent>
            </Dropdown>
        );
    }
}