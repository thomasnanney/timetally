import React, { Component } from 'react';

export default class Modal extends Component {

    render() {
        // Render nothing if the "show" prop is false
        if(!this.props.show) {
            return null;
        }

        // The gray background
        const backdropStyle = {
            position: 'fixed',
            top: 0,
            bottom: 0,
            left: 0,
            right: 0,
            backgroundColor: 'rgba(0,0,0,0.3)',
            padding: 50
        };

        // The modal "window"
        const modalStyle = {
            backgroundColor: '#fff',
            borderRadius: 5,
            maxWidth: 500,
            minHeight: 300,
            margin: '0 auto',
            padding: 30
        };

        return (
            <div className="backdrop" style={backdropStyle}>
                <div className="modal" style={modalStyle}>
                    <div className="header">
                        <h1>{this.props.header}</h1>
                    </div>
                    <div className="body">
                        <p>{this.props.body}</p>
                    </div>
                    <div className="footer text-right">
                        <button  className="btn btn-primary" onClick={this.props.onConfirm}>
                            Confirm
                        </button>
                        <button className="btn btn-default" onClick={this.props.onClose}>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        );
    }
}