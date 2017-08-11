import React, { Component } from 'react';

//components imports
import Textarea from 'react-textarea-autosize';

export default class ViewClientPane extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    componentWillMount(){

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
                                               onChange={this.props.updateClient}
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
                                               onChange={this.props.updateClient}
                                        />
                                        {
                                            this.props.errors && this.props.errors.email &&
                                            <small className="error">{this.props.errors.email}</small>
                                        }
                                    </div>
                                </div>
                                <br/>
                                <div className="row">
                                    <div className="col-xs-12">
                                            <Textarea
                                                className="tk-form-textarea"
                                                name="description"
                                                placeholder="Description..."
                                                value={this.props.client.description}
                                                onChange={this.props.updateClient}
                                            />
                                        {(this.props.errors) &&  this.props.errors.description
                                            ? <small className="error">{this.props.errors.description}</small>
                                            : ''
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
                                       onChange={this.props.updateClient}
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
                                       onChange={this.props.updateClient}
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
                                       onChange={this.props.updateClient}
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
                                       onChange={this.props.updateClient}
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
                                       onChange={this.props.updateClient}
                                       name="postalCode"
                                />
                                {
                                    this.props.errors && this.props.errors.postalCode &&
                                    <small className="error">{this.props.errors.postalCode}</small>
                                }
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





