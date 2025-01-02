<script setup lang="ts">
import ListMenu from "./components/ListMenu.vue";
</script>

<template>
    <v-layout>
        <v-app-bar color="primary" density="compact">
            <template v-slot:prepend>
                <ListMenu />
            </template>

            <v-app-bar-title>Humain Resource System</v-app-bar-title>

            <template v-slot:append>
                <v-btn icon="mdi-dots-vertical"></v-btn>
            </template>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <router-view v-slot="{ Component, route }">
                    <div :key="route.name">
                        <Component :is="Component" />
                    </div>
                </router-view>
            </v-container>
        </v-main>
    </v-layout>
</template>
