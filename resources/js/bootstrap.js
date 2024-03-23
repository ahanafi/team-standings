import axios from 'axios';
import * as Popper from '@popperjs/core';
import * as bootstrap from 'bootstrap';
import { showAlert, getToken } from './custom.js';

window.Popper = Popper;
window.axios = axios;

window.showAlert = showAlert;
window.getToken = getToken;

window.bootstrap = bootstrap;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
