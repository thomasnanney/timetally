import React, { Component } from 'react';

//components imports
import DropDownListItem from './DropDownListItem';

export default class DropDownList extends Component {

    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    render() {

        return (
            <div>
                <div className={"tk-dropdown tk-dropdown-list tk-root " + this.props.align}>
                    <ul className="no-list-style no-margin no-padding text-center">
                        {(this.props.items && this.props.items.length >0)
                            ?
                                this.props.items.map((item, id) =>
                                    <DropDownListItem item={item} onAction={this.props.updateInput} key={id} />
                                )
                            :
                                <a href="/projects/create">Add Project</a>
                        }
                    </ul>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}