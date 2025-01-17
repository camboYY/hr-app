<template>
    <div>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <span class="title">Edit Designation</span>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="handleSubmit">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="form.name"
                                        label="Name"
                                        required
                                    ></v-text-field>
                                    <template v-if="v$.name.$errors.length > 0">
                                        <div
                                            class="text-error"
                                            :error="v$.name.$errors"
                                        >
                                            Name is required
                                        </div>
                                    </template>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-textarea
                                        v-model="form.description"
                                        label="Description"
                                    ></v-textarea>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn
                                        type="submit"
                                        color="primary"
                                        :loading="form.loading"
                                        :disabled="form.loading"
                                    >
                                        Update
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar
            :timeout="2000"
            color="primary"
            variant="tonal"
            position="top"
            v-model="form.snackbar"
        >
            Designation has <strong>successfully</strong> edited.
        </v-snackbar>
    </div>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { computed, reactive } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();
        const router = useRouter();
        // Define the form fields using "reactive"
        const form = reactive({
            name: "",
            description: "",
            loading: false,
            snackbar: false,
        });

        const rules = computed(() => {
            return {
                name: { required }, // Name is required
                description: {}, // Description is optional
            };
        });

        // Use the "useVuelidate" function to perform form validation
        const v$ = useVuelidate(rules, form);

        // Function to handle form submission
        async function handleSubmit() {
            // Validate the form fields
            const result = await v$.value.$validate();
            if (!result) {
                return;
            }

            try {
                form.loading = true;
                // Call the "editDesignation" action to edit a existing designation
                await store.dispatch("Designation/editDesignation", {
                    ...store.state.Designation.designation,
                    name: form.name,
                    responsibilities: form.description,
                });

                // Reset the form fields
                form.name = "";
                form.description = "";
                // Show a success message
                form.snackbar = true;
                router.push({ name: "designation.list" });
            } catch (error) {
                console.error("An error occurred", error);
            } finally {
                form.loading = false;
            }
        }

        return {
            form,
            v$,
            handleSubmit,
        };
    },
};
</script>

<style lang="scss" scoped></style>
