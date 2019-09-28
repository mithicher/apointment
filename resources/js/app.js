/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import Zondicon from "vue-zondicons";
import VueSnackbar from "vue-snack";
import NProgress from "nprogress";
import VModal from "vue-js-modal";
import VPopover from "vue-js-popover";

// import "vue-snack/dist/vue-snack.min.css";

window.Snack = Vue.use(VueSnackbar, {});
Vue.component("Zondicon", Zondicon);
Vue.use(VModal);
Vue.use(VPopover, { tooltip: true });

Vue.filter("formatTime", function(value) {
    if (value) {
        const parts = value.split(":");
        return parts[0] + ":" + parts[1];
    } else {
        return "unknown";
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component("business-hours", require("./views/BusinessHours.vue").default);
Vue.component(
    "appointment-settings",
    require("./views/AppointmentSettings.vue").default
);
Vue.component("login", require("./views/TheLogin.vue").default);
Vue.component("navbar-dropdown", require("./views/NavbarDropdown.vue").default);
Vue.component("register", require("./views/TheRegister.vue").default);
Vue.component(
    "booking-form",
    require("./components/apoint/BookingForm.vue").default
);
Vue.component("appointments", require("./views/Appointments.vue").default);

// Vue.component("shop-settings", require("./views/ShopSettings.vue").default);

import TheAdmin from "./views/TheAdmin.vue";
import Dashboard from "./views/Dashboard.vue";
import BusinessHours from "./views/BusinessHours.vue";
import ShopSettings from "./views/ShopSettings.vue";
import ShopServices from "./views/ShopServices.vue";
import AccountSettings from "./views/AccountSettings.vue";
import NotFound from "./views/NotFound";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Fire = new Vue();

// before a request is made start the nprogress
axios.interceptors.request.use(config => {
    NProgress.start();
    return config;
});

// before a response is returned stop nprogress
axios.interceptors.response.use(response => {
    NProgress.done();
    return response;
});

Vue.use(require("vue-moment"));
Vue.use(VueRouter);

const routes = [
    {
        path: "/admin/dashboard",
        name: "dashboard",
        component: Dashboard,
        props: true
    },
    {
        path: "/admin/shops",
        name: "shops",
        component: ShopSettings,
        props: true
    },
    {
        path: "/admin/businesshours",
        name: "businesshours",
        component: BusinessHours,
        props: true
    },
    {
        path: "/admin/services",
        name: "services",
        component: ShopServices,
        props: true
    },
    {
        path: "/admin/settings",
        name: "settings",
        component: AccountSettings,
        props: true
    },
    { path: "/admin", component: NotFound }
];

const router = new VueRouter({
    mode: "history",
    routes
});

if (
    window.Laravel &&
    (window.Laravel.user.role == 1 || window.Laravel.user.role == 0)
) {
    router.beforeEach((to, from, next) => {
        if (to.fullPath !== "/login") {
            axios
                .get("/api/user", {
                    headers: {
                        "X-CSRF-TOKEN": window.Laravel
                            ? window.Laravel.csrfToken
                            : ""
                    }
                })
                .then(response => {
                    next();
                })
                .catch(error => {
                    // router.push("/login");
                    // @TODO Logout a user if status code is 401 Unauthorized
                    axios.post("/logout").then(() => {
                        window.location = "/";
                    });
                });
        } else {
            next();
        }
    });
}

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        // Start the route progress bar.
        NProgress.start();
    }
    next();
});

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    NProgress.done();
});

const app = new Vue({
    el: "#app",
    router,
    components: {
        TheAdmin
    }
});
