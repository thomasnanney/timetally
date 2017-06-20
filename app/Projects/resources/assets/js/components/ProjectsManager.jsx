import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import SearchBar from 'projects/ProjectManagerComponents/SearchBar'
import ProjectsList from 'projects/ProjectManagerComponents/ProjectsList'
class ProjectsManager extends Component{

    constructor(props){
        super(props);
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    render(){

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12">
                        <span className="tk-header">Projects</span>
                        <a href="/projects/add" className="btn tk-btn pull-right">Add Project</a>
                    </div>
                </div>
                <br></br>
                <SearchBar />
                <ProjectsList />
            </div>
        );
    }
}

if(document.getElementById('projectManager')){
    ReactDOM.render(<ProjectsManager/>, document.getElementById('projectManager'));
}