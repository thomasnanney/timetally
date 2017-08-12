import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//components imports
import SuccessNotification from 'core/SuccessNotification';
import ErrorNotification from 'core/ErrorNotification';
import {BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer} from 'recharts';
import jstz from 'jstimezonedetect';

class Dashboard extends Component {

    constructor(props) {
        super(props);
        this.state = {
            params: {
                startDate: new Date(getStartDate()),
                endDate: new Date(getEndDate()),
                filters: {
                    users: [],
                    clients: [],
                    projects: []
                },
                groupBy: 'user',
                subGroup: false,
                subGroupBy: '',
            },
            data: null,
            showSuccess: false,
            showError: false,
        }
    }

    componentDidMount() {

    }

    componentWillMount() {
        this.getBarData();
    }

    getBarData(){
        let self = this;
        let data = this.state.params;
        data.startDate = new Date(data.startDate).toUTCString();
        data.endDate = new Date(data.endDate).toUTCString();
        axios.post('/reports/getBarData', {
            data: data,
            timezone: jstz.determine().name(),
        })
            .then(function(response){
                data.startDate = new Date(data.startDate);
                data.endDate = new Date(data.endDate);
                let newState = self.state;
                newState.data = response.data;
                self.setState(newState);
            })
            .catch(function(error){
                console.log(error);
            });
    }

    showSuccess(){
        let self = this;
        this.setState({showSuccess: true});
        window.setTimeout(function(){
            self.setState({showSuccess: false});
        }, 3000);
    }

    showError(){
        let self = this;
        this.setState({showError: true});
        window.setTimeout(function(){
            self.setState({showError: false});
        }, 3000);
    }

    render() {

        const COLORS = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042'];
        const RADIAN = Math.PI / 180;
        const customTooltip = (data) => {
            if(typeof data.payload[0] !== 'undefined'){
                return (
                    <div className="raise pie-chart-tooltip">
                        <font>{data.payload[0].payload.name}</font>
                        <br/>
                        <font>{data.payload[0].payload.value} Hours</font>
                    </div>
                )
            }
        };

        const customBarTooltip = (data) => {
            if(typeof data.payload[0] !== 'undefined'){
                return (
                    <div className="raise pie-chart-tooltip">
                        <font>{data.payload[0].value} Hours</font>
                    </div>
                )
            }
        };

        return (
            <div>
                <SuccessNotification show={this.state.showSuccess}/>
                <ErrorNotification show={this.state.showError}/>
                <div>
                    <h2 className="text-center">Your week so far:</h2>
                </div>
                <div className="row">
                    <div className="col-xs-12 text-center">
                        <h3>Hours per day</h3>
                        <ResponsiveContainer minHeight={400}>
                            <BarChart  width={600} height={300}
                                       data={this.state.data}
                                       margin={{top: 5, right: 30, left: 20, bottom: 5}}
                            >
                                <XAxis dataKey="name"/>
                                <YAxis/>
                                <CartesianGrid strokeDasharray="3 3"/>
                                <Tooltip content={customBarTooltip.bind(this)}/>
                                <Legend />
                                <Bar dataKey="value" fill="#0088FE" />
                            </BarChart>
                        </ResponsiveContainer>
                    </div>
                </div>
            </div>
        );
    }
}

if(document.getElementById('dashboard')){
    ReactDOM.render(<Dashboard />, document.getElementById('dashboard'));
}

function getStartDate(){
    let today = new Date();
    today.setHours(0,0,0,0);
    return today.setDate(today.getDate()-(today.getDay() - 1));
}

function getEndDate(){
    let today = new Date();
    today.setHours(0,0,0,0);
    return today.setDate(today.getDate()+(7-today.getDay()));
}