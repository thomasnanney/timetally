import React, { Component } from 'react';

//components imports


export default class DropDownForm extends Component {

    constructor(props) {
        super(props);
    }

    componentDidMount() {

    }

    componentWillUnmount() {

    }

    render() {

        const elements = {
            0: {
                title: "Settings",
                link: "/workspaces/view/1",
            },
            1: {
                title: "Leave",
                link: "#",
            }
        };

        return (
            <div>
                <div className={"tk-dropdown set-project-dropdown tk-root " + this.props.align}>
                    <ul className="no-list-style no-margin no-padding text-center">
                        {Object.keys(options).map((option, id) =>
                            <DropDownMenuItem title={options[option].title} link={options[option].link} key={id}/>
                        )}
                    </ul>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}