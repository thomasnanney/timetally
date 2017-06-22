import React, { Component } from 'react';

//components imports

export default class ViewClientPane extends Component {
    constructor(props) {
        super(props);
        this.state ={
            projects: []
        };
    }

    componentDidMount() {

    }

    componentWillMount(){
        let self = this;
        axios.post('/clients/getProjects/'+tk.client.id)
            .then(function(response){
                self.setState({projects: response.data});
            })
            .catch(function(error){
               alert('We were unable to retrieve projects for this client.  Please reload the page or contanct you' +
                   ' system administrator');
            });
    }

    componentWillUnmount() {

    }

    render() {

        return (
            <div>
            {(() => {
                switch(this.props.activeView){
                    case 1:
                        return (
                            <div className="pane medium-container margin-center">
                                <div className="row">
                                    <div className="col-xs-12 ">
                                        <label>Client Name:</label>
                                        <input type="text" className="tk-form-input" value={tk.client.name}></input>
                                    </div>
                                </div>
                            </div>
                        );
                    case 2:
                        return (
                            <div className="pane medium-container margin-center">
                                <input type="text" className="tk-form-input" placeholder="Address 1" value={tk.client.address1}></input>
                                <input type="text" className="tk-form-input" placeholder="Address 2" value={tk.client.address2}></input>
                                <input type="text" className="tk-form-input" placeholder="City" value={tk.client.city}></input>
                                <input type="text" className="tk-form-input" placeholder="State" value={tk.client.state}></input>
                                <input type="text" className="tk-form-input" placeholder="Zip" value={tk.client.postalCode}></input>
                            </div>
                        );
                    case 3:
                        return (
                            <div className="pane medium-container margin-center">
                                <ul className="no-list-style no-margin no-padding list">
                                    {
                                        this.state.projects.length > 0
                                            ?
                                            this.state.projects.map((project) =>
                                                <li><a href={"/projects/view/" + project.id } className="no-link-style">{project.title}</a></li>
                                            )
                                            :
                                            <p>This client has no projects</p>
                                    }
                                </ul>
                                <div className="row">
                                    <div className="col-xs-12 text-center">
                                        <a href="/projects/create">+ Add Project</a>
                                    </div>
                                </div>
                            </div>
                        );
                }
            }) ()}
            </div>


        );
    }
}





