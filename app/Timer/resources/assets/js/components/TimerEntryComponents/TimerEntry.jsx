import React, {Component} from 'react';

export default class TimerEntry extends Component{

    constructor(props){
        super(props);
    }

    render(){
        return (
            <li key={this.props.entry.id}>
                <div className="row">
                    <div className="col-xs-12 col-md-6">
                        {this.props.entry.description}
                    </div>
                    <div className="col-xs-4 col-md-2">
                        {this.props.entry.project_name}
                    </div>
                    <div className="col-xs-4 col-md-2 text-right">
                        {
                            this.props.entry.billable
                                ?
                                    <i className="fa fa-usd"/>
                                :
                                    ''
                        }
                    </div>
                    <div className="col-xs-4 col-md-2">
                        {msToTime(new Date(this.props.entry.endTime) - new Date(this.props.entry.startTime))}
                        <i className="fa fa-trash pull-right error clickable" aria-hidden="true" onClick={() => this.props.removeItem(this.props.entry)}/>
                    </div>
                </div>
            </li>
        )
    }
}

function msToTime(duration) {
    let milliseconds = parseInt((duration%1000)/100)
        , seconds = parseInt((duration/1000)%60)
        , minutes = parseInt((duration/(1000*60))%60)
        , hours = parseInt((duration/(1000*60*60))%24);

    hours = (hours < 10 && hours >= 0) ? "0" + hours : hours;
    minutes = (minutes < 10 && minutes >= 0) ? "0" + minutes : minutes;
    seconds = (seconds < 10 && seconds >= 0) ? "0" + seconds : seconds;

    return hours + ":" + minutes + ":" + seconds;
}