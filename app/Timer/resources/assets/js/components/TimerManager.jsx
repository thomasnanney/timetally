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
        let key = new Date(entry.startTime).yyyymmdd();
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

    removeEntry(entry){
        console.log(entry);
        let self = this;
        axios.post('/timer/delete/' + entry.id)
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    let newState = self.state;
                    let key = new Date(entry.startTime).yyyymmdd();
                    console.log(key);
                    let newArray = newState.timeEntries[key].filter(function(oldEntry){
                        return ! (oldEntry.id == entry.id);
                    });

                    newState.timeEntries[key] = newArray;
                    self.setState(newState);
                    console.log(newState);
                }
            })
            .catch(function(error){
               console.log(error);
            });
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

// Date.prototype.yyyymmdd = function() {
//     let mm = this.getMonth() + 1; // getMonth() is zero-based
//     let dd = this.getDate();
//
//     return [this.getFullYear(),
//         (mm>9 ? '' : '0') + mm,
//         (dd>9 ? '' : '0') + dd
//     ].join('-');
// };