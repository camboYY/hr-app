<template>
    <v-card>
        <v-card-title>
            {{ title }}
        </v-card-title>
        <hr />
        <v-card-text>
            <div class="d-flex flex-wrap">
                <div class="my-2 mr-2">
                    <v-icon
                        size="24px"
                        :color="
                            leave?.leave_type_setting?.leave_balance > 0
                                ? 'error'
                                : 'primary'
                        "
                    >
                        {{ leave ? " mdi-door-closed" : "mdi-door-open" }}
                    </v-icon>
                    Leave Status:
                    {{
                        leave?.leave_type_setting?.leave_balance > 0
                            ? "Leave Requested"
                            : "Leave Available"
                    }}
                </div>
                <div class="my-2">
                    <v-icon
                        size="24px"
                        :color="route.name === 'home' ? 'primary' : 'error'"
                    >
                        {{
                            route.name === "home"
                                ? "mdi-home"
                                : "mdi-account-multiple"
                        }}
                    </v-icon>
                    Current Page: {{ route.name }}
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed, ref } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

const title = ref("vue");
const description = ref(
    "Vue.js is a progressive, component-based JavaScript framework."
);
const route = useRoute();
const store = useStore();

const leave = computed(() => store.getters["Leave/leave"]);

console.log(leave);
</script>

<style lang="scss" scoped></style>
