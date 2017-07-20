import React, {Component} from 'react';
import Timepicker from 'react-timepicker';
import DayPicker from 'react-day-picker';
import 'react-day-picker/lib/style.css';

export default class DropDownDateTimePicker extends Component{

    constructor(props){
        super(props);
        this.state = {
            selectedDay: new Date(),
            selectedTime: new Date().getHours() +':'+new Date().getMinutes(),
            selectedTimeOfDay: ((new Date().getHours > 11) ? 'PM' : 'AM' )
        }
    }

    componentWillMount(){

    }

    componentWillMount(){

    }

    handleDayClick(day){
        this.setState({selectedDay: day});
    }

    handleTimeClick(hour, minute){
        this.setState({selectedTime: hour+':'+minute})

    }

    handleTimeOfDayClick(event){
        let value = event.target.value;
        this.setState({selectedTimeOfDay: value});
    }

    handleSave(){
        let time = this.state.selectedTime + ' ' + this.state.selectedTimeOfDay;
        this.props.updateInput( this.state.selectedDay.toDateString(), time);
    }

    render(){
        return(
            <div>
                <div className={"date-time-picker tk-dropdown tk-dropdown-list tk-root " + this.props.align}>
                    <div className="row">
                        <div className="col-xs-12 col-sm-6">
                            <DayPicker onDayClick={this.handleDayClick.bind(this)} selectedDays={this.state.selectedDay}/>
                        </div>
                        <div className="col-xs-12 col-sm-6">
                            <Timepicker size={300} radius={80} militaryTime={false} onChange={this.handleTimeClick.bind(this)}/>
                            <div className="row">
                                <div className="col-xs-12">
                                    <div className="btn-group" role="group">
                                        <button type="button" className={"btn btn-primary " + (this.state.selectedTimeOfDay == 'AM' ? 'active' : '')} value="AM" onClick={(e) => this.handleTimeOfDayClick(e)}>AM</button>
                                        <button type="button" className={"btn btn-primary " + (this.state.selectedTimeOfDay == 'PM' ? 'active' : '')} value="PM" onClick={(e) => this.handleTimeOfDayClick(e)}>PM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-xs-12">
                            <button type="button" className="btn btn-success" onClick={this.handleSave.bind(this)}>Save</button>
                        </div>
                    </div>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}