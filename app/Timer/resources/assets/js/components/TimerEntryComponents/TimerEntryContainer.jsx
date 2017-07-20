import React, {Component} from 'react';

import TimerEntry from './TimerEntry';

export default class TimerEntryContainer extends Component{

    constructor(props){
        super(props);
    }

    componentWillMount(){

    }

    render(){

        return(
            <div className="log-container">
                <div className="row">
                    <div className="col-xs-12">
                        {this.props.timeEntries
                            ?
                            <div>
                                {Object.keys(this.props.timeEntries).map((day, key) => (
                                    <ul key={key}>
                                        <li key={day}>{printHeader(day)}</li>
                                        {this.props.timeEntries[day].map((entry) => (
                                            <TimerEntry entry={entry} key={entry.id} removeItem={this.props.removeItem}/>
                                        ))
                                        }
                                    </ul>
                                ))
                                }
                            </div>
                            :
                            <p>You do not have any entries to display</p>
                        }
                    </div>
                </div>
            </div>
        );
    }
}

function printHeader(date){
    let todayDate = new Date();
    console.log("TODAY: " + todayDate);
    let yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    console.log("YESTERDAY: " + yesterday);
    yesterday = yesterday.yyyymmdd();
    let today = todayDate.yyyymmdd();
    console.log(date);
    console.log(todayDate.getTimezoneOffset());
    if(date == today){
        return 'Today';
    }else if(date == yesterday){
        return 'Yesterday'
    }else{
        let options = {
            weekday: "long", year: "numeric", month: "short",
            day: "numeric"
        };
        let newDate = new Date(date);
        console.log("NEW DATE 1: " + newDate);
        newDate = newDate.toLocaleTimeString("en-us", options);
        console.log("NEW DATE 2: " + newDate);
        newDate =  newDate.substr(0, newDate.lastIndexOf(","));
        console.log("NEW DATE 3: " + newDate);
        return newDate;
    }
}
