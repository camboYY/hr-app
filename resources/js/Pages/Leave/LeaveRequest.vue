<template>
    <div>
        <v-card>
            <card-title>
                <h2>Fill Leave Request Form</h2>
            </card-title>
            <v-divider></v-divider>
            <v-card-content>
                <div class="container">
                    <v-form
                        v-model="valid"
                        lazy-validation
                        @submit.prevent="submitForm"
                    >
                        <v-text-field
                            v-model="from.leaveType"
                            label="Leave Type"
                            required
                        />

                        <v-date-input
                            v-model="from.leaveStartDate"
                            label="Start Date"
                            required
                        ></v-date-input>

                        <v-date-input
                            v-model="from.leaveEndDate"
                            label="End Date"
                            required
                        ></v-date-input>

                        <v-text-field
                            v-model="from.leaveReason"
                            label="Leave Reason"
                            required
                        />
                        <v-btn
                            color="primary"
                            type="submit"
                            variant="elevated"
                            :disabled="!valid"
                            class="self-center"
                            >Submit</v-btn
                        >
                    </v-form>
                </div>
            </v-card-content>
        </v-card>
    </div>
</template>

<script>
import { VDateInput } from "vuetify/labs/VDateInput";
export default {
    components: {
        VDateInput,
    },
    data() {
        return {
            from: {
                leaveType: "",
                leaveStartDate: new Date(),
                leaveEndDate: new Date(),
                leaveReason: "",
                valid: false,
            },
        };
    },
    methods: {
        async submitForm() {
            try {
                // Perform form submission logic here
                console.log("Form submitted successfully", this.from);
            } catch (error) {
                console.error("Error submitting form:", error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.container {
    max-width: 800px;
    margin: auto;
}
</style>
