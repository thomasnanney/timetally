import React, { Component } from 'react';

//components imports

import DropDownMenuItem from 'core/DropDownMenuItem';

export default class DropDownMenu extends Component {

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
                <div className={"tk-dropdown tk-root " + this.props.align}>
                    <ul className="no-list-style no-margin no-padding text-center">
                        {this.props.items.map((item, id) =>
                            <DropDownMenuItem name={item.name} link={item.link} key={id} />
                        )}
                    </ul>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}