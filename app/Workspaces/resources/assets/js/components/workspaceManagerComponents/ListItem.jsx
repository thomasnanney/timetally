import React, { Component } from 'react';

//components imports
import DropDownMenu from '../DropDownMenu';

export default class ListItem extends Component {

    constructor(props) {
        super(props);
        this.state = {
            active: false,
        }

        this.handleClick = this.handleClick.bind(this);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    handleClick(){
        this.setState((prevState, props) => ({
            active: !prevState.active,
        }));
    }

    render() {
        return (
            <div className="thin-border-bottom table-row">
                <div className={"table-cell valign-bottom tk-dropdown-container relative " + (this.state.active ? "active " : "")}>
                    <i className="fa fa-bars clickable" aria-hidden="true" onClick={this.handleClick}></i>
                    <DropDownMenu options={this.props.options} align="align-left"/>
                </div>
                <div className="table-cell valign-bottom">{this.props.name}</div>
                <div className="table-cell valign-bottom"></div>
            </div>
        );
    }
}