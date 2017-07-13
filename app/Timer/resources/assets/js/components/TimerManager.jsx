import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import TimerBar from './TimerBarComponents/TimerBar';
import TimerEntryContainer from './TimerEntryComponents/TimerEntryContainer';

class TimerManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            timeEntries: {},
        }
    }

    componentWillMount(){
        this.updateEntries();
    }

    updateEntries(){
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
        this.updateEntries();
    }

    removeEntry(entry){
        console.log(entry);
        let self = this;
        axios.post('/timer/delete/' + entry.id)
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    self.updateEntries();
                }
            })
            .catch(function(error){
               console.log(error);
            });
    }

    promptToDelete(entry){

    }

    render(){

        return (
            <div>
                <TimerBar updateEntries={this.updateEntries.bind(this)}/>
                <hr/>
                <TimerEntryContainer timeEntries={this.state.timeEntries} removeItem={this.removeEntry.bind(this)}/>
            </div>
        );
    }
}

if(document.getElementById("timerManager")){
        ReactDOM.render(<TimerManager/>, document.getElementById("timerManager"));
}