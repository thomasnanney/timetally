import React, {Component} from 'react';


export default class ReportListGroup extends Component{
    constructor(props){
        super(props);
        this.state = {
            expanded: false,
        }
    }

    componentWillMount(){
    }

    componentDidUpdate() {
    }

    toggleExpand(){
        let newState = this.state;
        newState.expanded = !this.state.expanded;
        let self = this;
        this.setState(newState);
    }

    render(){

        return (

            <li>
                {
                    this.state.expanded
                        ? <i className="fa fa-minus-square-o clickable" aria-hidden="true" onClick={() => this.toggleExpand()}/>
                        : <i className="fa fa-plus-square-o clickable" aria-hidden="true" onClick={() => this.toggleExpand()}/>
                }
                {" " + this.props.data.title}
                <span className="list-item-time pull-right"><strong><u>{this.props.data.totalTime} hours</u></strong></span>
                <ul className="no-list-style">
                    {
                        this.props.data.subGroups
                            ?
                            <div>
                                {
                                    this.state.expanded && Object.keys(this.props.data.subGroups).map((group, id) => (
                                       <ReportListGroup data={this.props.data.subGroups[group]} key={id}/>
                                    ))
                                }
                            </div>
                            :
                            <div>
                                {
                                    this.state.expanded && this.props.data.entries.map((entry, id) => (
                                        <li key={id}>{entry.date} - {entry.description} <span className="list-item-time pull-right">{entry.time} hours</span></li>
                                    ))
                                }
                            </div>
                    }
                </ul>
            </li>
        )
    }
}