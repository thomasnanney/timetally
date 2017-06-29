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
            errors: {}
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
            data: self.state.project
        })
            .then(function(response){
                console.log(response.data);
                self.setState({loading:false});
                if(response.data.errors){
                    let errors = response.data.messages;
                    self.setState({errors: errors});
                }
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
                                <li className={"tab " + (this.state.activeView == 1 ? 'active': '')} onClick={() => this.makeTabActive(1)}>
                                    {(this.state.errors.title || this.state.errors.scope || this.state.errors.description)
                                        ?   <i className="fa fa-exclamation error" aria-hidden="true"></i>
                                        :   ''
                                    }
                                    General
                                </li>
                                <li className={"tab " + (this.state.activeView == 2 ? 'active': '')} onClick={() => this.makeTabActive(2)}>
                                    {(this.state.errors.clientID || this.state.errors.billableType || this.state.errors.billableRate || this.state.errors.billableHourlyType)
                                        ?   <i className="fa fa-exclamation error" aria-hidden="true"></i>
                                        :   ''
                                    }
                                    Details
                                </li>
                                <li className={"tab " + (this.state.activeView == 3 ? 'active': '')} onClick={() => this.makeTabActive(3)}>
                                    {(this.state.errors.users)
                                        ?   <i className="fa fa-exclamation error" aria-hidden="true"></i>
                                        :   ''
                                    }
                                    Users
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div className="pane-container">
                        <ViewProjectPane activeView={this.state.activeView} project={this.state.project} clients={this.state.clients} updateInput={this.updateInput.bind(this)} users={this.state.users} errors={this.state.errors}/>
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