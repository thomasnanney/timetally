import React, { Component } from 'react';

import ProjectsListItem from 'projects/ProjectManagerComponents/ProjectsListItem'

export default class ProjectsList extends Component{

    constructor(props){
        super(props);
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    render(){

        return (
            <div className="list table project-manager-table">
                <div className="list-header table-row thick-border-bottom">
                    <div className="table-cell valign-bottom"></div>
                    <div className="table-cell valign-bottom">Project </div>
                    <div className="table-cell valign bottom">Client</div>
                </div>
                {
                    this.props.projects.length
                    ?
                        this.props.projects.map((project) =>
                            <ProjectsListItem project={project} key={project.id} removeItem={this.props.removeItem}/>
                        )
                    :
                        <p>You do not have any projects...slacker.</p>
                }
            </div>
        )
    }
}