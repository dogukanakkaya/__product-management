// any CSS you import will output into a single css file (app.css in this case)
import './app.css';

import App from './svelte/App.svelte';

const app = new App({
    target: document.body,
});