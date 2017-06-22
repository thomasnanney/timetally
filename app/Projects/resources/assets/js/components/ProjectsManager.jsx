import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import SearchBar from 'projects/ProjectManagerComponents/SearchBar'
import ProjectsList from 'projects/ProjectManagerComponents/ProjectsList'
class ProjectsManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            projects: [],
        }
    }

    componentDidMount(){

    }

    componentWillMount(){
        let self = this;
        axios.post('/users/getAllProjects')
            .then(function(response){
                self.setState({projects : response.data});
            })
            .catch(function(error){
                console.log(error);
                // alert('We were unable to retrieve your projects.  Try reloading the page, or contact your System' +
                    // ' Administrator');
            });
    }

    componentWillUnmount(){

    }

    render(){

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12">
                        <span className="tk-header">Projects</span>
                        <a href="/projects/create" className="btn tk-btn pull-right">Add Project</a>
                    </div>
                </div>
                <br></br>
                <SearchBar />
                <ProjectsList projects={this.state.projects}/>
            </div>
        );
    }
}

if(document.getElementById('projectManager')){
    ReactDOM.render(<ProjectsManager/>, document.getElementById('projectManager'));
}