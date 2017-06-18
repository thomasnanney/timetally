import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports

export default class DropDownMenu extends Component {

    constructor(props) {
        super(props);
        // this.state
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    render() {

        return (
        <li><a href={this.props.link}>{this.props.title}</a></li>
        );
    }
}