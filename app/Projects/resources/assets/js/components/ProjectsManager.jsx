import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import SearchBar from 'projects/ProjectManagerComponents/SearchBar'
import ProjectsList from 'projects/ProjectManagerComponents/ProjectsList'
import Modal from 'core/Modal';

class ProjectsManager extends Component{

    constructor(props){
        super(props);
        this.state = {
            projects: [],
            promptDelete: false,
            promptDeleteProject: null,
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
                alert('We were unable to retrieve your projects.  Try reloading the page, or contact your System' +
                    ' Administrator');
            });
    }

    componentWillUnmount(){

    }

    promptDelete(project){
        this.setState({promptDelete: true});
        this.setState({promptDeleteProject: project});
    }

    cancelDelete(){
        this.setState({promptDelete: false});
        this.setState({promptDeleteProject: null});
    }

    removeItem(){
        let self = this;
        axios.post('/projects/delete/' + self.state.promptDeleteProject.id)
            .then(function(response){
                if(response.status == 'fail'){
                    alert(response.messages[0]);
                }
            })
            .catch(function(error){
                console.log(error);
                alert("We experienced an error while attempting to delete your project.  PLease reload the page and" +
                    " try again.");
            });
        let newProjects = this.state.projects.filter(function(project){
           return project.id != self.state.promptDeleteProject.id;
        });
        this.setState({projects: newProjects});
        this.setState({promptDelete: false});
        this.setState({promptDeleteProject: null});

    }

    render(){

        if(this.state.promptDelete) {
            var header = "Are you sure?";
            var body = "Are you sure you want to delete  " + this.state.promptDeleteProject.title;
        }

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
                <ProjectsList projects={this.state.projects} removeItem={this.promptDelete.bind(this)}/>

                {this.state.promptDelete &&
                    <Modal show={true} header={header} body={body} onConfirm={this.removeItem.bind(this)} onClose={this.cancelDelete.bind(this)} />
                }
            </div>
        );
    }
}

if(document.getElementById('projectManager')){
    ReactDOM.render(<ProjectsManager/>, document.getElementById('projectManager'));
}