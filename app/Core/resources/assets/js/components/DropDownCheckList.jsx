import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class DropDownCheckList extends Component{

    constructor(props){
        super(props);
    }

    componentWillMount(){

    }

    componentDidMount(){

    }

    componentDidUpdate(){
        if(this.props.show){
            ReactDOM.findDOMNode(this).focus();
        }
    }

    handleBlur(e) {
        let self = this;
        let currentTarget = e.currentTarget;
        setTimeout(function() {
            if (!currentTarget.contains(document.activeElement)) {
                self.props.collapse();
            }
        }, 0);
    }

    render(){

        return(
            <div tabIndex="0" onBlur={this.handleBlur.bind(this)} ref="self" className="full-width">
                <div className={"tk-dropdown tk-root" + this.props.align + " " + (this.props.show ? 'active' : '')}>
                    <div className="row">
                        <div className="col-xs-12">
                            <ul className="no-list-style no-padding list">
                            {
                                this.props.data.map((item) => (
                                    <li key={item.value} className="">
                                        <label className="switch">
                                            <input type="checkbox"
                                                   name={item.value}
                                                   checked={item.selected}
                                                   onChange={this.props.updateInput}
                                            />
                                            <div className="slider round"></div>
                                        </label>
                                        {item.title}
                                    </li>
                                ))
                            }
                            </ul>
                        </div>
                    </div>
                </div>
                <div className="tk-arrow"></div>
            </div>
        );
    }
}
