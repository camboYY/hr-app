import { createApp } from "vue";
import App from "./App.vue";
import "./bootstrap";
import router from "./Router/index";
import store from "./Store/index";
import vuetify from "./vuetify";

createApp(App).use(router).use(store).use(vuetify).mount("#app");
