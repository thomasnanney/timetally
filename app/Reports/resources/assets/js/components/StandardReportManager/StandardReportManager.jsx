import React, {Component} from 'react';

import ReactLoading from 'react-loading';
import ReportFilters from './ReportsFilters';
import ReportList from './ReportList';
import DropDownDatePicker from 'core/DropDownDatePicker';
import DateFormat from 'dateformat';
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

        // let data = {
        //     groupByType: "client",
        //     subGroup: true,
        //     subGroupType: "project",
        //     totalTime: '156',
        //     groups: [
        //         {
        //             title: 'Group 1',
        //             totalTime: '128 Hours',
        //             subGroups: [
        //                 {
        //                     title: 'Sub Group 1',
        //                     totalTime: '50 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //                 {
        //                     title: 'Sub Group 2',
        //                     totalTime: '55 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //                 {
        //                     title: 'Sub Group 3',
        //                     totalTime: '60 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //             ]
        //         },
        //         {
        //             title: 'Group 2',
        //             totalTime: '28 Hours',
        //             subGroups: [
        //                 {
        //                     title: 'Sub Group 1',
        //                     totalTime: '50 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //                 {
        //                     title: 'Sub Group 2',
        //                     totalTime: '55 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //                 {
        //                     title: 'Sub Group 3',
        //                     totalTime: '60 Hours',
        //                     entries: [
        //                         {
        //                             title: 'Entry 1',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 2',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 3',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 4',
        //                             time: '5 hours',
        //                         },
        //                         {
        //                             title: 'Entry 5',
        //                             time: '5 hours',
        //                         },
        //                     ]
        //                 },
        //             ]
        //         },
        //         {
        //             title: 'Group 3',
        //             totalTime: '28 Hours',
        //             entries: [
        //                 {
        //                     title: 'Entry 1',
        //                     time: '5 hours',
        //                 },
        //                 {
        //                     title: 'Entry 2',
        //                     time: '5 hours',
        //                 },
        //                 {
        //                     title: 'Entry 3',
        //                     time: '5 hours',
        //                 },
        //                 {
        //                     title: 'Entry 4',
        //                     time: '5 hours',
        //                 },
        //                 {
        //                     title: 'Entry 5',
        //                     time: '5 hours',
        //                 },
        //             ]
        //         }
        //     ]
        // };
        //
        // this.setState({data: data});

        let barData = [
            {name: 'Day 1', hours: 40, amt: 2400},
            {name: 'Day 2', hours: 60, amt: 2400},
            {name: 'Day 3', hours: 30, amt: 2400},
            {name: 'Day 4', hours: 10, amt: 2400},
            {name: 'Day 5', hours: 90, amt: 2400},
            {name: 'Day 6', hours: 0, amt: 2400},
            {name: 'Day 7', hours: 0, amt: 2400},
        ];

        this.setState({barData: barData});

        let pieData = [
            {name: 'Client 1', value: 40},
            {name: 'Client 2', value: 30},
            {name: 'Client 3', value: 90},
            {name: 'Client 4', value: 5},
        ];

        this.setState({pieData: pieData});
    }

    toggleMenu(menu){
        let newState = this.state;
        newState[menu] = !this.state[menu];
        this.setState(newState);
    }

    getReportData(){
        let self = this;
        axios.post('/reports/getReport/standard', {data: this.state.params})
            .then(function(response){
                console.log(response.data.data);
                let newState = self.state;
                newState.data = response.data.data;
                newState.data.barData = response.data.data.barData.sort(function(a, b){
                   return new Date(a.name).getDate() - new Date(b.name).getDate();
                });
                self.setState(newState, function(){
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

    updateStartDate(startDate){
        let newState = this.state;
        newState.params.startDate = startDate;
        this.setState(newState);
    }

    updateEndDate(endDate){
        let newState = this.state;
        newState.params.endtDate = endDate;
        this.setState(newState);
    }

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
        }else{
            let newState = self.state;
            newState.params[item] = value;
            self.setState(newState);
        }
    }

    render(){

        const COLORS = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042'];
        const RADIAN = Math.PI / 180;
        const customTooltip = (data) => {
            if(typeof data.payload[0] !== 'undefined'){
                return (
                    <div className="raise pie-chart-tooltip">
                        <font>{data.payload[0].value} Hours</font>
                    </div>
                )
            }
        };

        const customLabel = (data) => {
            if(typeof data.name !== 'undefined'){
                return (
                    <text fill={data.fill} stroke={data.stroke} x={data.x} y={data.y} alignmentBaseline="middle" className="recharts-text recharts-pie-label-text" textAnchor={data.textAnchor}><tspan x={data.x} dy="0em">{data.name}</tspan></text>
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
                                <div className={"start-date inline-block relative tk-dropdown-container "}>
                                    <label>From:  </label>
                                    <input type="text" value={this.state.params.startDate ? DateFormat(this.state.params.startDate, "mm/dd/yy") : ''} className="tk-timer-input inline-block width-auto" onClick={ ()=>this.toggleMenu('isStartDateMenuActive')} placeholder="Start Date"/>
                                    <DropDownDatePicker updateInput={this.updateParam.bind(this, 'startDate')} collapse={this.toggleMenu.bind(this, 'isStartDateMenuActive')} show={this.state.isStartDateMenuActive} align="align-right"/>
                                </div>
                                <div className={"start-date inline-block relative tk-dropdown-container "}>
                                    <label className="inline-block">To:  </label>
                                    <input type="text" value={this.state.params.endDate ? DateFormat(this.state.params.endDate, "mm/dd/yy") : ''} className="tk-timer-input  inline-block width-auto" onClick={ ()=>this.toggleMenu('isEndDateMenuActive')} placeholder="End Date"/>
                                    <DropDownDatePicker updateInput={this.updateParam.bind(this, 'endDate')} collapse={this.toggleMenu.bind(this, 'isEndDateMenuActive')} show={this.state.isEndDateMenuActive} align="align-right"/>
                                </div>
                            </div>
                        </div>
                        <ReportFilters updateReport={this.getReportData.bind(this)} updateFilters={this.updateFilters.bind(this)}/>
                            <ResponsiveContainer minHeight={400}>
                                <BarChart  width={600} height={300} data={this.state.data.barData}
                                          margin={{top: 5, right: 30, left: 20, bottom: 5}}>
                                    <XAxis dataKey="name"/>
                                    <YAxis/>
                                    <CartesianGrid strokeDasharray="3 3"/>
                                    <Tooltip/>
                                    <Legend />
                                    <Bar dataKey="value" fill="#8884d8" />
                                </BarChart>
                            </ResponsiveContainer>
                        <div className="row">
                            <div className="col-xs-12 col-md-6">
                                <p>Total Hours: {this.state.data.totalTime}</p>
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
                            <div className="col-xs-12 col-md-5">
                                <ResponsiveContainer minHeight={400}>
                                    <PieChart width={600} height={600}>
                                        <Pie
                                            data={this.state.pieData}
                                            outerRadius={150}
                                            fill="#8884d8"
                                            label={customLabel.bind(this)}
                                        >
                                            {
                                                this.state.pieData.map((entry, index) => <Cell key={index} fill={COLORS[index % COLORS.length]} />)
                                            }
                                        </Pie>
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
    return today.setDate(today.getDate()-(today.getDay() - 1));
}

function getEndDate(){
    let today = new Date();
    return today.setDate(today.getDate()+(7-today.getDay()));
}