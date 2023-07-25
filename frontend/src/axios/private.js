import axios from 'axios';
import apiUrl from './index.js';

let token = window.localStorage.getItem('token_');

const instance = axios.create({
    baseURL: apiUrl,
    headers: {
        "Content-Type": "application/json",
        "authorization": `Bearer ${token}`
    }
});

export default instance;