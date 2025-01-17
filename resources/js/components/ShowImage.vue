<template>
    <div class="text-center pa-4">
        <v-dialog
            :model-value="dialog"
            @update:modelValue="$emit('update:dialog', $event)"
            max-width="700"
            persistent
        >
            <v-card prepend-icon=" mdi-file-image" title="Show detail of item">
                <img :src="source" style="height: fit-content" />

                <template v-slot:actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="onConfirm">OK</v-btn>
                </template>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    props: {
        source: {
            type: String,
            required: false,
            default: "",
        },
        dialog: {
            type: Boolean,
            required: true,
            default: false,
        },
        onConfirm: {
            type: Function,
            required: true,
        },
    },
};
</script>
