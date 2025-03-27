<template>
    <v-snackbar
        :timeout="2000"
        color="primary"
        variant="tonal"
        v-model="isVisible"
    >
        {{ message }}
        <template v-slot:actions>
            <v-btn color="white" @click="isVisible = false">Close</v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import { defineProps, ref, watch } from "vue";

const props = defineProps({
    message: String,
    timeout: {
        type: Number,
        default: 3000,
    },
    color: {
        type: String,
        default: "success",
    },
    show: Boolean,
});

const isVisible = ref(props.show);

// Watch for prop updates
watch(
    () => props.show,
    (newVal) => {
        isVisible.value = newVal;
    }
);
</script>
