import React, {Component} from 'react';

import TimerEntry from './TimerEntry';
import DateFormat from 'dateformat';

import ReactPaginate from 'react-paginate';

export default class TimerEntryContainer extends Component{

    constructor(props){
        super(props);
        this.state = {
            offset: 0,
            perPage: 50,
        }
    }

    componentWillMount(){

    }

    updatePerPage(evt){
        let newState = this.state;
        newState.perPage = evt.target.value;
        this.setState(newState);
    }

    handlePageClick(data){
        let newState = this.state;
        let selected = data.selected;
        newState.offset = Math.ceil(selected * newState.perPage);
        this.setState(newState);
    };

    render(){

        return(
            <div className="log-container">
                <div className="row">
                    <div className="col-xs-12">
                        {Object.keys(this.props.timeEntries).length !== 0
                            ?
                            <div>
                                {Object.keys(this.props.timeEntries).map((day, key) => (
                                    <ul key={key} className="no-padding">
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
                            <div className="large-container dark drop text-center">
                                <h2>You do not have any time entries to display.  Do you get paid to do nothing?</h2>
                            </div>
                        }
                    </div>
                </div>
            </div>
        );
    }
}

function printHeader(date){
    let todayDate = new Date();
    let yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    yesterday = yesterday.yyyymmdd();
    let today = todayDate.yyyymmdd();
    if(date == today){
        return 'Today';
    }else if(date == yesterday){
        return 'Yesterday'
    }else{
        return DateFormat(date, 'dddd, mmm, dS, yyyy', true);
    }
}
