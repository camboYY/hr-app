<template>
    <div class="text-center">
        <v-menu>
            <template v-slot:activator="{ props: menu }">
                <v-tooltip location="top">
                    <template v-slot:activator="{ props: tooltip }">
                        <v-app-bar-nav-icon
                            v-bind="mergeProps(menu, tooltip)"
                        ></v-app-bar-nav-icon>
                    </template>
                    <span>I am a list of menu</span>
                </v-tooltip>
            </template>
            <v-card class="menu-list" max-width="300">
                <v-list>
                    <v-list-item
                        class="item-title"
                        v-for="(item, index) in items"
                        :key="index"
                    >
                        <router-link
                            :to="item.path"
                            active-class="active"
                            @click="item.title === 'Logout' && userLogout()"
                        >
                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>
                        </router-link>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-menu>
    </div>
</template>
<script>
import { mergeProps } from "vue";
import { mapActions } from "vuex";

export default {
    data: () => ({
        activeItem: "active",
        items: [
            { title: "Dashboard", path: "/dashboard" },
            { title: "Department", path: "/department/list" },
            { title: "Designation", path: "/designation/list" },
            { title: "Employee", path: "/employee/list" },
            { title: "Contract", path: "/contract" },
            { title: "About", path: "/about" },
            { title: "Logout", path: "/login" },
        ],
    }),
    methods: {
        mergeProps,
        ...mapActions("Auth", ["userLogout"]),
    },
};
</script>
<style scoped>
.menu-list {
    text-align: center;
    width: 100%;
    border: 1px solid transparent;

    a {
        text-decoration: none;

        .v-list-item-title {
            color: #fff;
            &:hover {
                color: gray;
            }
        }
    }
    .active .v-list-item-title {
        width: 100%;
        background-color: rgb(34, 33, 32);
        color: #978c8c;
    }
}
</style>
