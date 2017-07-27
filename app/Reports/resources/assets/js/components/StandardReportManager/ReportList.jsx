import React, {Component} from 'react';

import ReportListGroup from './ReportListGroup';

export default class ReportList extends Component{
    constructor(props){
        super(props);
    }

    componentWillMount(){

    }

    updateGroup(type, event){
        this.props.updateGroupings(type, event.target.value);
    }

    render(){

        return (
            <div>
                <div className="row">
                    <div className="col-xs-6">
                        <strong>Group By:</strong>
                        <select className="search-input" value={this.props.params.groupBy} onChange={this.updateGroup.bind(this, 'groupBy')}>
                            <option value="user">User</option>
                            <option value="client">Client</option>
                            <option value="project">Project</option>
                        </select>
                    </div>
                    <div className="col-xs-6">
                        <strong>Sub-group:</strong>
                        <select className="search-input" value={this.props.params.subGroupBy} onChange={this.updateGroup.bind(this, 'subGroupBy')}>
                            <option value="">None</option>
                            <option value="user">User</option>
                            <option value="client">Client</option>
                            <option value="project">Project</option>
                        </select>
                    </div>
                </div>
                <hr/>
                <ul className="no-list-style main-list no-padding">
                    {
                        this.props.data.groups.map((group, id) => (
                            <ReportListGroup data={group} key={id}/>
                        ))
                    }
                </ul>
            </div>
        )
    }
}