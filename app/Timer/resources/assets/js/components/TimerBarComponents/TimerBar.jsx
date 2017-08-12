import React, {Component} from 'react';

import DropDownSelect from 'core/DropDownSelect';
import DropDownDateTimePicker from './DropDownDateTimePicker';

export default class TimerBar extends Component{

    constructor(props){
        super(props);
        this.state = {
            entry: {
                description: '',
                projectID: '',
                billable: false,
                startTime: null,
                endTime: null
            },
            project: {
                title: ''
            },
            timer: '00:00:00',
            running: false,
            projects: [],
            errors: {},
        }
    }

    componentWillMount(){
        let self = this;
        axios.post('/users/getAllProjects')
            .then(function(response){
                if(response.status == 200){
                    self.setState({projects: response.data});
                }
            })
            .catch(function(error){
                console.log(error);
            });
    }

    componentDidMount(){

    }

    startTimer(){
        //if start and end date set, add time entry
        if(Date.parse(this.state.entry.startTime) && Date.parse(this.state.entry.endTime)){
            //add time entry
            let totalTime = msToTime(this.state.entry.endTime - this.state.entry.startTime);
            console.log("Had both: total time = " + totalTime);
            let newState = this.state;
            newState.timer = totalTime;
            this.setState(newState);
            this.submitEntry();
        }else{
            this.timerID = setInterval(
                () => this.tick(),
                1000
            );
            //otherwise start timer
            this.setState({running: true});
            if(!Date.parse(this.state.entry.startTime)){
                let newEntry = this.state.entry;
                newEntry['startTime'] = new Date();
                this.setState({entry: newEntry});
            }
        }
    }

    stopTimer(){
        clearInterval(this.timerID);
        let newState = this.state;
        newState.entry.endTime = new Date();
        this.setState(newState);
        this.submitEntry();
        this.setState({running: false});
    }

    submitEntry(){
        let self = this;
        let data = this.state.entry;
        data.startTime = new Date(data.startTime).toUTCString();
        data.endTime = new Date(data.endTime).toUTCString();
        axios.post('timer/create', {
            data: data
        })
            .then(function(response){
                data.startTime = new Date(data.startTime);
                data.endTime = new Date(data.endTime);
                if(response.status == 200){
                    if(response.data.errors == 'true'){
                        let newState = self.state;
                        newState.errors = response.data.messages;
                        self.setState(newState);
                        setTimeout(() => self.removeErrors(), 10000);
                    }else{
                        self.props.updateEntries();
                        let newState = self.state;
                        newState.entry = {
                            description: '',
                            projectID: '',
                            billable: false,
                            startTime: null,
                            endTime: null,
                        };
                        newState.project = {
                            title: ''
                        };
                        newState.timer = '00:00:00';
                        self.setState(newState);
                    }
                }
               console.log(response);
            })
            .catch(function(error){
                console.log(error);
            });
    }

    removeErrors(){
        let newState = this.state;
        newState.errors = {};
        this.setState(newState);
    }

    tick(){
        let newTimer = msToTime(new Date() - this.state.entry.startTime)
        console.log(newTimer);
        this.setState({timer: newTimer});
    }

    updateEntry(evt){
        let name = evt.target.name;
        let value = evt.target.type === 'checkbox' ? evt.target.checked : evt.target.value;
        let newState = this.state;
        newState.entry[name] = value;
        this.setState(newState);
    }

    updateProject(evt){
        let value = evt.target.value;
        let newState = this.state;
        newState.project = value;
        newState.entry.projectID = value.id;
        this.setState(newState, function(){
            console.log(this.state.entry);
        });
    }

    render(){

        let errorMessages = [];
        if(this.state.errors){
            for(let error in this.state.errors){
                if(this.state.errors.hasOwnProperty(error)){
                    errorMessages.push(this.state.errors[error][0]);
                }
            }
        }

        return(
            <div>
                <div className="timer-container table">
                    <div className="table-cell tc-md-6">
                        <input type="text"
                               className="tk-timer-input timer-element"
                               placeholder="Task Description..."
                               onChange={this.updateEntry.bind(this)}
                               value={this.state.entry.description}
                               name="description"
                        />
                    </div>
                    <div className="timer-project table-cell tc-md-3">
                        <DropDownSelect
                            data={this.state.projects}
                            updateInput={this.updateProject.bind(this)}
                            triggerName={this.state.project.title.length ? this.state.project.title : "Select project"}
                            name="project"
                            emptyMessage="You have no projects.  Go add some and get to work!"
                        />
                        {/*//ToDo: Update to new drop down*/}
                        {/*<input type="text" value={this.state.project.title} className="tk-timer-input" onClick={ ()=>this.toggleMenu('isProjectMenuActive')} placeholder="Project / Task"/>*/}
                        {/*<DropDownList items={this.state.projects} updateInput={this.updateProject.bind(this)} align="align-right"/>*/}
                    </div>
                    <div className="timer-billable table-cell tc-md-1 text-center">
                        <i className={" timer-element clickable fa fa-usd " + (this.state.entry.billable ? 'active' : '')} aria-hidden="true"/>
                        <input
                            type="checkbox"
                            name="billable"
                            className="timer-element icon-check-box clickable"
                            onClick={this.updateEntry.bind(this)}
                            checked={this.state.entry.billable}
                        />
                    </div>
                    <div className="timer-project table-cell tc-md-3">
                        <DropDownDateTimePicker updateInput={this.updateEntry.bind(this)} time={this.state.entry.startTime} placeholder="Start time" name="startTime"/>
                    </div>
                    <div className="timer-project tc-md-3 table-cell">
                        <DropDownDateTimePicker updateInput={this.updateEntry.bind(this)} time={this.state.entry.endTime} placeholder="End time" name="endTime"/>
                    </div>
                    <div className="timer-start-stop table-cell tc-md-1 text-center">
                        {
                            this.state.running
                                ?
                                <i className="fa clickable fa-pause-circle error timer-element" aria-hidden="true" onClick={this.stopTimer.bind(this)}/>
                                :
                                <i className="fa clickable fa-play-circle timer-element" aria-hidden="true" onClick={this.startTimer.bind(this)}/>
                        }
                    </div>
                    <div className="timer-clock table-cell tc-md-2">
                        {this.state.running
                            ?
                            <p className="">{this.state.timer}</p>
                            :
                            <p className="">00:00:00</p>
                        }
                    </div>
                </div>
                {
                    errorMessages.length > 0 &&
                        <div className="error-box">
                            {
                                errorMessages.map((error) => (
                                    <li>{error}</li>
                                ))
                            }
                        </div>
                }
            </div>
        );
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