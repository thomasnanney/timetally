import React, {Component} from 'react';

import DropDownList from './DropDownList';
import DropDownDateTimePicker from './DropDownDateTimePicker';

import DateFormat from 'dateformat';

export default class TimerBar extends Component{

    constructor(props){
        super(props);
        this.state = {
            entry: {
                description: '',
                projectID: '',
                billable: false,
                startTime: null,
                endTime: null,
            },
            timer: '00:00:00',
            project: {
                title: '',
            },
            running: false,
            projects: null,
            isProjectMenuActive: false,
            isStartDateMenuActive: false,
            isEndDateMenuActive: false,
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
                console.log(response);
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
        this.submitEntry();
        this.setState({running: false});
    }

    submitEntry(){
        let self = this;
        axios.post('timer/create', {
            data: self.state.entry
        })
            .then(function(response){
                if(response.status == 200){
                    if(response.data.errors == 'true'){
                        let newState = self.state;
                        newState.errors = response.data.messages;
                        self.setState(newState);
                        setTimeout(() => self.removeErrors(), 10000);
                    }else{
                        console.log("success");
                        let newState = self.state;
                        newState.entry = {
                            description: '',
                            projectID: '',
                            billable: false,
                            startTime: null,
                            endTime: null,
                        }

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

    toggleMenu(menu){
        let newState = this.state;
        newState[menu] = !this.state[menu];
        this.setState(newState);
    }

    updateInput(event){
        let name = event.target.name;
        let value = event.target.value;
        this.updateState(name, value);
    }

    updateState(name, value){
        let newEntry = this.state.entry;
        newEntry[name] = value;
        this.setState({ entry: newEntry});
    }

    updateProject(project){
        let newState = this.state;
        newState.project = project;
        this.setState(newState);
        this.toggleMenu('isProjectMenuActive');

    }

    toggleBillable(){
        let newEntry = this.state.entry;
        newEntry['billable'] = !this.state.entry.billable;
        this.setState({entry: newEntry});
    }

    updateProjectStartTime(date, time){
        let newEntry = this.state.entry;
        newEntry['startTime'] = new Date(date + ' ' + time);
        this.setState({entry: newEntry});
        console.log(this.state.entry);
        this.toggleMenu('isStartDateMenuActive');
    }

    updateProjectEndTime(date, time){
        let newEntry = this.state.entry;
        newEntry['endTime'] = new Date(date + ' ' + time);
        this.setState({entry: newEntry});
        console.log(this.state.entry);
        this.toggleMenu('isEndDateMenuActive');
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
                <div className="timer-container">
                    <div className="row">
                        <div className="co-xs-12 col-md-6 timer-description">
                            <input type="text"
                                   className="tk-timer-input"
                                   placeholder="Task Description..."
                                   onChange={this.updateInput.bind(this)}
                                   value={this.state.entry.description}
                                   name="description"
                            />
                        </div>
                        <div className="col-xs-12 col-md-6">
                            <div className="row">
                                <div className={"timer-project col-xs-3 relative tk-dropdown-container " + (this.state.isProjectMenuActive ? 'active' :'')}>
                                    <input type="text" value={this.state.project.title} className="tk-timer-input" onClick={ ()=>this.toggleMenu('isProjectMenuActive')} placeholder="Project / Task"/>
                                    <DropDownList items={this.state.projects} updateInput={this.updateProject.bind(this)} align="align-right"/>
                                </div>
                                <div className="timer-billable col-xs-1 text-center ">
                                    <i className={"clickable fa fa-usd " + (this.state.entry.billable ? 'active' : '')} aria-hidden="true" onClick={this.toggleBillable.bind(this)}/>
                                </div>
                                <div className="timer-set-time col-xs-5 text-center relative tk-dropdown-container">
                                    <div className="row">
                                        <div className="col-xs-6 no-padding">
                                            <div className={"timer-project relative tk-dropdown-container " + (this.state.isStartDateMenuActive ? 'active' :'')}>
                                                <input type="text" value={this.state.entry.startTime ? DateFormat(this.state.entry.startTime, "mm/dd/yy h:MM TT") : ''} className="tk-timer-input" onClick={ ()=>this.toggleMenu('isStartDateMenuActive')} placeholder="start time"/>
                                                <DropDownDateTimePicker updateInput={this.updateProjectStartTime.bind(this)} align="align-right"/>
                                            </div>
                                        </div>
                                        <div className="col-xs-6 no-padding">
                                            <div className={"timer-project relative tk-dropdown-container " + (this.state.isEndDateMenuActive ? 'active' :'')}>
                                                <input type="text" value={this.state.entry.endTime ? DateFormat(this.state.entry.endTime, "mm/dd/yy h:MM TT") : ''} className="tk-timer-input" onClick={ ()=>this.toggleMenu('isEndDateMenuActive')} placeholder="end time"/>
                                                <DropDownDateTimePicker updateInput={this.updateProjectEndTime.bind(this)} align="align-right"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="timer-start-stop col-xs-1 text-center">
                                    {
                                        this.state.running
                                            ?
                                                <i className="fa fa-pause-circle error" aria-hidden="true" onClick={this.stopTimer.bind(this)}/>
                                            :
                                                <i className="fa fa-play-circle" aria-hidden="true" onClick={this.startTimer.bind(this)}/>
                                    }
                                </div>
                                <div className="timer-clock col-xs-2">
                                    {this.state.running
                                        ?
                                            <p>{this.state.timer}</p>
                                        :
                                            <p>00:00:00</p>
                                    }
                                </div>
                            </div>
                        </div>
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

    hours = (hours < 10 && hours > 0) ? "0" + hours : hours;
    minutes = (minutes < 10 && minutes >= 0) ? "0" + minutes : minutes;
    seconds = (seconds < 10 && seconds >= 0) ? "0" + seconds : seconds;

    return hours + ":" + minutes + ":" + seconds;
}