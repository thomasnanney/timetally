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
                        {this.props.timeEntries.map((day, id) => (
                                <ul key={id}>
                                    <li key={day.id}>{day.date}</li>
                                    {day.entries.map((entry) =>(
                                        <TimerEntry entry={entry} key={entry.id}/>
                                        ))
                                    }
                                </ul>
                            ))
                        }
                    </div>
                </div>
            </div>
        );
    }
}
