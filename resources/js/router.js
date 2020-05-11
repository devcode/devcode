import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./page/Home.vue";
import Galeri from "./page/Galeri.vue";
import Cerita from "./page/Cerita.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: Home,
        name: "home"
    },
    {
        path: "/galeri",
        component: Galeri,
        name: "galeri"
    },
    {
        path: "/cerita",
        component: Cerita,
        name: "cerita"
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
