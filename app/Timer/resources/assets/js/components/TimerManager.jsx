import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import TimerBar from './TimerBarComponents/TimerBar';
import TimerEntryContainer from './TimerEntryComponents/TimerEntryContainer';

class TimerManager extends Component{

    constructor(props){
        super(props);
    }

    componentWillMount(){

    }

    render(){

        let timeEntryList = [
            {
                date: 'Today',
                entries: [
                    {
                        id: 1,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                    {
                        id: 2,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                    {
                        id: 3,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                ]
            },
            {
                date: 'Yesterday',
                entries: [
                    {
                        id: 4,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                    {
                        id: 5,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                    {
                        id: 6,
                        description: 'Description',
                        client: 'Client 1',
                        project: 'Project 1',
                        billable: true,
                        time: '1:30:00'
                    },
                ]
            }
        ];

        return (
            <div>
                <TimerBar/>
                <hr/>
                <TimerEntryContainer timeEntries={timeEntryList}/>
            </div>
        );
    }
}

if(document.getElementById("timerManager")){
        ReactDOM.render(<TimerManager/>, document.getElementById("timerManager"));
}