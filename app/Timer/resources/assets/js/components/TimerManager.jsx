import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import TimerBar from './TimerBarComponents/TimerBar';
import TimerEntryContainer from './TimerEntryComponents/TimerEntryContainer';

class TimerManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            timeEntries: {}
        }
    }

    componentWillMount(){
        let self = this;
        axios.post('/users/getAllTimeEntries')
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    let newState = self.state;
                    newState.timeEntries = response.data;
                    self.setState(newState);
                }
            })
            .catch(function(error){
                console.log(error);
            });
    }

    addEntry(entry){
        console.log(entry);
        let newState = this.state;
        let key = entry.startTime.yyyymmdd();
        console.log(key);
        console.log(newState);
        if(newState.timeEntries[key]){
            newState.timeEntries[key].push(entry);
        }else{
            newState.timeEntries[key] = [];
            newState.timeEntries[key].push(entry);
        }

        this.setState(newState);
    }

    removeEntry(){

    }

    render(){

        return (
            <div>
                <TimerBar addEntry={this.addEntry.bind(this)}/>
                <hr/>
                <TimerEntryContainer timeEntries={this.state.timeEntries} removeItem={this.removeEntry.bind(this)}/>
            </div>
        );
    }
}

if(document.getElementById("timerManager")){
        ReactDOM.render(<TimerManager/>, document.getElementById("timerManager"));
}