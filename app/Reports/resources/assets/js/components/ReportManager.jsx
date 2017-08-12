import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import StandardReportManager from './StandardReportManager/StandardReportManager';

class ReportManager extends Component{
    constructor(props){
        super(props);
        this.state = {
            mode: 'standard'
        }
    }

    componentWillMount(){

    }

    switchMode(){
        let newMode = ((this.state.mode == 'standard' ? 'custom' : 'standard'));
        this.setState({mode: newMode})
    }

    render(){

        return (
            <div>
                <div className="row">
                    <div className="col-xs-12 col-md-6">
                        <h2>Reports</h2>
                    </div>
                    <div className="col-xs-12 col-md-6">
                        {/*<button className="btn tk-btn-success pull-right">Custom Report</button>*/}
                    </div>
                </div>
                {(this.state.mode == "standard")
                    ?
                        <StandardReportManager switchMode={this.switchMode.bind(this)}/>
                    :
                        <CustomReportManager switchMode={this.switchMode.bind(this)}/>
                }
            </div>
        )
    }
}



if(document.getElementById("reportManager")){
    ReactDOM.render(<ReportManager/>, document.getElementById("reportManager"));
}