import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ReactLoading from 'react-loading';

//components imports

import ViewProjectPane from 'projects/ViewProjectComponents/ViewProjectPane'

class ViewProject extends Component {

    constructor(props) {
        super(props);
        this.state ={
            activeView: 1,
            project: tk.project,
            clients: [],
            users: [],
            loading: false,
        };
    }

    componentDidMount() {

    }

    toggleBillableType(item){
        if(item == 'billableRate'){
            this.props.project.billabeRate = (this.props.project.billableRate == 'hourly' ? 'fixed' : 'hourly');
        }
    }

    updateInput(name, value){
        let newProject = this.state.project;
        newProject[name] = value;
        this.setState({ project: newProject});
    }

    componentWillMount(){

        let self = this;
        axios.post('/users/getAllClients')
            .then(function(response){
                self.setState({clients: response.data});
            })
            .catch(function(error){
                alert('We were unable to retrieve all clients, please reload the page or contact your System' +
                    ' Administrator');
            });

        axios.post('/projects/getUsers/' + this.state.project.id)
            .then(function(response){
                self.setState({users:response.data});
            })
            .catch(function(error){
                alert('We were unable to retrieve all users for this project, please reload the page or contact your' +
                    ' System' +
                    ' Administrator');
            });
    }

    saveProject(){
        let self = this;
        this.setState({loading: true});
        axios.post('/projects/edit/'+this.state.project.id, {
            data: this.state.project
        })
            .then(function(response){
                console.log(response.data);
                self.setState({loading:false});
            })
            .catch(function(error){
                alert("We were unable to save your project.  Please try again.");
            });
    }


    componentWillUnmount() {

    }

    makeTabActive(tab){
        this.setState({activeView: tab});
    }
    render() {

        return (
            <div>
                <div className="tile raise">
                    <div className="row">
                        <div className="col-xs-12">
                            <ul className="no-list-style horizontal-menu text-center thin-border-bottom">
                                <li className={"tab " + (this.state.activeView == 1 ? 'active': '')} onClick={() => this.makeTabActive(1)}>General</li>
                                <li className={"tab " + (this.state.activeView == 2 ? 'active': '')} onClick={() => this.makeTabActive(2)}>Details</li>
                                <li className={"tab " + (this.state.activeView == 3 ? 'active': '')} onClick={() => this.makeTabActive(3)}>Users</li>
                            </ul>
                        </div>
                    </div>
                    <div className="pane-container">
                        <ViewProjectPane activeView={this.state.activeView} project={this.state.project} clients={this.state.clients} updateInput={this.updateInput.bind(this)} users={this.state.users}/>
                    </div>
                    <div className="row">
                        <div className="col-xs-12 text-right">
                            <button className="btn tk-btn" onClick={this.saveProject.bind(this)}>Save</button>
                        </div>
                    </div>
                </div>
                {
                    this.state.loading
                        ?
                        <div className="page-loading">
                            <ReactLoading type='spin' color='#777' className='loading-img'/>
                        </div>
                        :
                        ''
                }
            </div>
        );
    }
}

if(document.getElementById('viewProject')){
    ReactDOM.render(<ViewProject/>, document.getElementById('viewProject'));
}