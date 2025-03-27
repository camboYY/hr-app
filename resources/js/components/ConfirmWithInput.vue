<template>
    <div class="pa-4 text-center">
        <v-dialog v-model="isVisible" max-width="600">
            <v-card>
                <v-card-text>
                    <v-text-field
                        label="Comment"
                        v-model="comment"
                        type="text"
                    ></v-text-field>
                </v-card-text>
                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        text="Close"
                        variant="plain"
                        @click="handleClose"
                    ></v-btn>

                    <v-btn
                        color="primary"
                        text="Save"
                        variant="tonal"
                        @click="sendData"
                    ></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script setup>
import { defineEmits, defineProps, ref, shallowRef, watch } from "vue";

const comment = shallowRef("");

const emit = defineEmits(["updateData", "update:show"]);

const sendData = () => {
    emit("updateData", comment.value);
    emit("update:show", false);
    comment.value = "";
};

const handleClose = () => {
    emit("update:show", false);
    comment.value = "";
};

const props = defineProps({
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
