import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import TimerBar from './TimerBarComponents/TimerBar';
import TimerEntryContainer from './TimerEntryComponents/TimerEntryContainer';
import Modal from 'core/Modal';

class TimerManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            timeEntries: {},
            promptDelete: false,
            promptDeleteEntry: null
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

    removeEntry(){
        let self = this;
        let entry = this.state.promptDeleteEntry;
        axios.post('/timer/delete/' + entry.id)
            .then(function(response){
                console.log(response);
                if(response.status == 200){
                    self.setState({promptDelete: false});
                    self.updateEntries();
                }
            })
            .catch(function(error){
               console.log(error);
            });
    }

    promptToDelete(entry){
        let newState = this.state;
        newState.promptDelete = true;
        newState.promptDeleteEntry = entry;
        this.setState(newState);
    }

    cancelDelete(){
        let newState = this.state;
        newState.promptDelete = false;
        newState.promptDeleteEntry = null;
        this.setState(newState);
    }

    render(){
        if(this.state.promptDelete){
            var header = 'Are you sure?';
            var body = 'Are you sure you want to delete ' + this.state.promptDeleteEntry.description;
        }

        return (
            <div>
                <TimerBar updateEntries={this.updateEntries.bind(this)}/>
                <hr/>
                <TimerEntryContainer timeEntries={this.state.timeEntries} removeItem={this.promptToDelete.bind(this)}/>
                {this.state.promptDelete &&
                <Modal show={true} header={header} body={body} onConfirm={this.removeEntry.bind(this)} onClose={this.cancelDelete.bind(this)} />
                }
            </div>
        );
    }
}

if(document.getElementById("timerManager")){
        ReactDOM.render(<TimerManager/>, document.getElementById("timerManager"));
}