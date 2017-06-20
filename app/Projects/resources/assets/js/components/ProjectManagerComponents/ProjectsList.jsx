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

        const projects = [
            {
                id: '1',
                name: 'Project 1',
                hours: '5',
                client: 'Client 3',
                link: '/projects/view/1',
                scope: 'private',
            },
            {
                id: '2',
                name: 'Project 2',
                hours: '10',
                client: 'Client 1',
                link: '/projects/view/1',
                scope: 'public',
            },
            {
                id: '3',
                name: 'Project 3',
                hours: '3',
                client: 'Client 3',
                link: '/projects/view/1',
                scope: 'private',

            },
        ];

        return (
            <div className="list table project-manager-table">
                <div className="list-header table-row thick-border-bottom">
                    <div className="table-cell valign-bottom"></div>
                    <div className="table-cell valign-bottom">Project </div>
                    <div className="table-cell valign bottom">Client</div>
                    <div className="table-cell valign bottom">Hours</div>
                </div>
                {
                    projects.map((project, id) =>
                        <ProjectsListItem project={project} key={id}/>
                    )
                }
            </div>
        )
    }
}