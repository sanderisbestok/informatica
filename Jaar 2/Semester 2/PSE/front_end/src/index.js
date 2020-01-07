import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import registerServiceWorker from './misc/registerServiceWorker';

import 'font-awesome/css/font-awesome.min.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'react-anything-sortable/sortable.css';

import './css/spinner.css'
import './css/theme.css'
import './css/custom.css'

ReactDOM.render(<App />, document.getElementById('root'));
registerServiceWorker();
