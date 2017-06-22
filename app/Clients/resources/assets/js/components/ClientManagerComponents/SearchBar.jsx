import React, { Component } from 'react';

export default class SearchBar extends Component{

    constructor(props){
        super(props);
    }

    componentDidMount(){

    }

    componentWillUnmount(){

    }

    render(){
        return (
            <div className="row">
                <div className="col-xs-12">
                    <div className="search-bar text-right drop">
                        <i className="fa fa-search" aria-hidden="true"></i>
                        <input type="text" className="search-input" placeholder="Search..."></input>
                    </div>
                </div>
            </div>
        );
    }
}