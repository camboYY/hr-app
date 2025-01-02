<template>
    <div>
        <template>
            <div class="text-center pa-4">
                <v-dialog
                    :model-value="dialog"
                    @update:modelValue="$emit('update:dialog', $event)"
                    max-width="400"
                    persistent
                >
                    <template v-slot:activator="{ props: activatorProps }">
                        <v-btn v-bind="activatorProps"> Show Dialog </v-btn>
                    </template>

                    <v-card
                        prepend-icon="mdi-alert-circle"
                        text="Are you sure wanted to delete this item?"
                        title="Confirmation"
                    >
                        <template v-slot:actions>
                            <v-spacer></v-spacer>

                            <v-btn @click="onCancel"> Disagree </v-btn>

                            <v-btn @click="onConfirm"> Agree </v-btn>
                        </template>
                    </v-card>
                </v-dialog>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        dialog: {
            type: Boolean,
            required: true,
            default: false,
        },
        title: {
            type: String,
            required: true,
        },
        message: {
            type: String,
            required: true,
        },
        onConfirm: {
            type: Function,
            required: true,
        },
        onCancel: {
            type: Function,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped></style>
