import React, { Component } from 'react';

export default class ErrorNotification extends Component {

    render() {
        // Render nothing if the "show" prop is false
        if(!this.props.show) {
            return null;
        }

        return (
            <div className="loading">
                <div className="v-h-center">
                    <img className="notification-img" src="/images/error.png" alt="successful save image"/>
                    <h2 className="text-center error-text">Error!</h2>
                </div>
            </div>
        );
    }
}