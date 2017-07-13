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
                        {this.props.entry.client} - {this.props.entry.project}
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
                        {this.props.entry.time}
                    </div>
                </div>
            </li>
        )
    }
}