import React, {Component} from 'react';

import ReactLoading from 'react-loading';
import ReportFilters from './ReportsFilters';
import ReportList from './ReportList';
import DropDownDatePicker from 'core/DropDownDatePicker';
import {BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer} from 'recharts';
import {PieChart, Pie, Sector, Cell } from 'recharts';

export default class StandardReportManager extends Component{
    constructor(props){
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
            loading: false,
            isStartDateMenuActive: false,
            isEndDateMenuActive: false,
        }
    }

    componentWillMount(){
        // retrieve data
        this.getReportData();
    }

    toggleMenu(menu){
        let newState = this.state;
        newState[menu] = !this.state[menu];
        this.setState(newState);
    }

    getReportData(){
        let self = this;
        let data = this.state.params;
        data.startDate = new Date(data.startDate).toUTCString();
        data.endDate = new Date(data.endDate).toUTCString();
        axios.post('/reports/getReport/standard', {data: data})
            .then(function(response){
                data.startDate = new Date(data.startDate);
                data.endDate = new Date(data.endDate);
                let newState = self.state;
                newState.data = response.data;
                self.setState(newState, () => {
                    console.log(self.state.data);
                });
            })
            .catch(function(error){
                console.log(error);
            });
    }

    updateFilters(type, id, value){
        let self = this;
        if(value){
            let newState = this.state;
            newState.params.filters[type].push(id);
            this.setState(newState, ()=> (
                console.log(self.state.params.filters)
            ))
        }else{
            let newState = this.state;
            newState.params.filters[type] = newState.params.filters[type].filter(function(ele) {
                return ele != id
            });
            self.setState(newState, () => (
                console.log(self.state.params.filters)
            ));
        }

    }

    updateParam(param, value){
        let newState = this.state;
        newState.params[param] = value;
        this.setState(newState);
    }

    // ToDo: Remove and use update Param
    updateStartDate(startDate){
        let newState = this.state;
        newState.params.startDate = startDate;
        this.setState(newState);
    }

    // ToDo: Remove and use update Param
    updateEndDate(endDate){
        let newState = this.state;
        newState.params.endtDate = endDate;
        this.setState(newState);
    }

    //ToDo: upon successfully setting state make this update the data instead of hitting apply
    updateGroupings(item, value){
        let self = this;
        if(item == 'subGroupBy'){
            let newState = self.state;
            if(value == '') {
                newState.params.subGroup = false;
            }else{
                newState.params.subGroup = true;
            }
            newState.params.subGroupBy = value;
            self.setState(newState);
            self.getReportData();
        }else{
            let newState = self.state;
            newState.params[item] = value;
            self.setState(newState);
            self.getReportData();
        }
    }

    render(){

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
                {
                !(this.state.data || this.state.loading)
                    ?
                    <div className="page-loading">
                        <ReactLoading type='spin' color='#777' className='loading-img'/>
                    </div>
                    :
                    <div>
                        <div className="row">
                            <div className="col-xs-12">
                                <div className={"start-date inline-block"}>
                                    <DropDownDatePicker updateInput={this.updateParam.bind(this, 'startDate')} date={this.state.params.startDate} triggerLabel="From:  "/>
                                </div>
                                <div className={"start-date inline-block"}>
                                    <DropDownDatePicker updateInput={this.updateParam.bind(this, 'endDate')} date={this.state.params.endDate} triggerLabel="To:  "/>
                                </div>
                            </div>
                        </div>
                        <ReportFilters updateReport={this.getReportData.bind(this)} updateFilters={this.updateFilters.bind(this)}/>
                        <div className="row">
                            <div className="col-xs-12 text-center">
                                <h3>Hours per day</h3>
                                <ResponsiveContainer minHeight={400}>
                                    <BarChart  width={600} height={300}
                                               data={this.state.data.barData}
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

                        <div className="row">
                            <div className="col-xs-12 col-md-6">
                                <p><strong>Total Hours:</strong> {this.state.data.totalTime} hours</p>
                            </div>
                            <div className="col-xs-12 col-md-6 text-right">
                                <button><i className="fa fa-file-pdf-o" aria-hidden="true"/>  PDF</button>
                                <button><i className="fa fa-file-excel-o" aria-hidden="true"/>  XLS</button>
                                <button><i className="fa fa-file-excel-o" aria-hidden="true"/>  CSV</button>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-xs-12 col-md-7">
                                <ReportList data={this.state.data} updateGroupings={this.updateGroupings.bind(this)} params={this.state.params}/>
                            </div>
                            <div className="col-xs-12 col-md-5 text-center">
                                <h3>Hours per client</h3>
                                <ResponsiveContainer minHeight={600}>
                                    <PieChart width={600} height={600}>
                                        <Pie
                                            data={this.state.data.pieData}
                                            outerRadius={150}
                                            dataKey="value"
                                            label={false}
                                            labelLine={false}
                                        >
                                            {
                                                this.state.data.pieData.map((entry, index) => <Cell key={index} fill={COLORS[index % COLORS.length]} />)
                                            }
                                        </Pie>
                                        <Legend layout="vertical"/>
                                        <Tooltip content={customTooltip.bind(this)}/>
                                    </PieChart>
                                </ResponsiveContainer>
                            </div>
                        </div>
                    </div>
                }
            </div>
        )
    }
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