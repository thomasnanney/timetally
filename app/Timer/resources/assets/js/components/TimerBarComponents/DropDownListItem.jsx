import React, { Component } from 'react';

//components imports

export default class DropDownListItem extends Component {

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
            <li key={this.props.item.id} onClick={() => this.props.onAction(this.props.item)}>{this.props.item.title}</li>
        );
    }
}