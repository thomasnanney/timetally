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

    updateInput(event){
        let name = event.target.name;
        let value = event.target.value;
        this.props.updateClient(name, value);
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
                                        <input type="text"
                                               name="name"
                                               className="tk-form-input"
                                               value={this.props.client.name}
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        {
                                            this.props.errors && this.props.errors.name &&
                                                <small className="error">{this.props.errors.name}</small>
                                        }
                                        <label>Email:</label>
                                        <input type="text"
                                               name="email"
                                               className="tk-form-input"
                                               value={this.props.client.email}
                                               onChange={this.updateInput.bind(this)}
                                        />
                                        {
                                            this.props.errors && this.props.errors.email &&
                                            <small className="error">{this.props.errors.email}</small>
                                        }
                                    </div>
                                </div>
                            </div>
                        );
                    case 2:
                        return (
                            <div className="pane medium-container margin-center">
                                <input type="text"
                                       className="tk-form-input"
                                       placeholder="Address 1"
                                       value={this.props.client.address1}
                                       onChange={this.updateInput.bind(this)}
                                       name="address1"
                                />
                                {
                                    this.props.errors && this.props.errors.address1 &&
                                    <small className="error">{this.props.errors.address1}</small>
                                }
                                <input type="text"
                                       className="tk-form-input"
                                       placeholder="Address 2"
                                       value={this.props.client.address2}
                                       onChange={this.updateInput.bind(this)}
                                       name="address2"
                                />
                                {
                                    this.props.errors && this.props.errors.address2 &&
                                    <small className="error">{this.props.errors.address2}</small>
                                }
                                <input type="text"
                                       className="tk-form-input"
                                       placeholder="City"
                                       value={this.props.client.city}
                                       onChange={this.updateInput.bind(this)}
                                       name="city"
                                />
                                {
                                    this.props.errors && this.props.errors.city &&
                                    <small className="error">{this.props.errors.city}</small>
                                }
                                <input type="text"
                                       className="tk-form-input"
                                       placeholder="State"
                                       value={this.props.client.state}
                                       onChange={this.updateInput.bind(this)}
                                       name="state"
                                />
                                {
                                    this.props.errors && this.props.errors.state &&
                                    <small className="error">{this.props.errors.state}</small>
                                }
                                <input type="text"
                                       className="tk-form-input"
                                       placeholder="Zip"
                                       value={this.props.client.postalCode}
                                       onChange={this.updateInput.bind(this)}
                                       name="postalCode"
                                />
                                {
                                    this.props.errors && this.props.errors.postalCode &&
                                    <small className="error">{this.props.errors.postalCode}</small>
                                }
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
                <div className="row">
                    <div className="col-xs-12">
                        <button className="btn btn-default pull-right" onClick={() => this.props.saveClient()}>Save</button>
                    </div>
                </div>
            </div>


        );
    }
}





