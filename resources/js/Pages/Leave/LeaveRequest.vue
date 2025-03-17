<template>
    <div>
        <v-card>
            <v-card-title>
                <h2 style="text-align: center">Fill Leave Request Form</h2>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <div class="container">
                    <v-form
                        v-model="form.valid"
                        lazy-validation
                        @submit.prevent="submitForm"
                    >
                        <v-autocomplete
                            v-model:search="search"
                            :items="filterItems"
                            label="Search relief"
                            chips
                            :rules="[required]"
                            :loading="loading"
                            item-title="text"
                            item-value="value"
                            v-model="form.relief_id"
                        ></v-autocomplete>
                        <v-select
                            label="Leave Options"
                            :items="leaveOption"
                            item-title="label"
                            item-value="value"
                            v-model="form.leaveOption"
                            :rules="[required]"
                        >
                            ></v-select
                        >
                        <v-date-input
                            v-show="isCompensated"
                            v-model="form.compensateDate"
                            label="Compensate Date"
                        ></v-date-input>
                        <v-select
                            label="Leave Type"
                            :items="leaveType"
                            item-title="label"
                            item-value="value"
                            v-model="form.leaveType"
                            :rules="[required]"
                        ></v-select>
                        <v-date-input
                            v-model="form.leaveStartDate"
                            label="Start Date"
                            :rules="[required]"
                        ></v-date-input>

                        <v-date-input
                            v-model="form.leaveEndDate"
                            label="End Date"
                            :rules="[required]"
                        ></v-date-input>

                        <v-text-field
                            v-model="form.leaveReason"
                            label="Leave Reason"
                            :rules="[required]"
                        />
                        <v-btn
                            color="primary"
                            type="submit"
                            variant="elevated"
                            :disabled="!form.valid"
                            class="mt-10 items-center"
                            >Submit</v-btn
                        >
                    </v-form>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { useRoute } from "vue-router";
import { VDateInput } from "vuetify/labs/VDateInput";
import { mapActions, mapGetters } from "vuex";
export default {
    components: {
        VDateInput,
    },
    setup() {
        const route = useRoute();
        return { route };
    },
    data() {
        return {
            search: "",
            items: [],
            isCompensated: false,
            loading: false,
            leaveOption: [
                { label: "Afternoon", value: "AFTERNOON" },
                { label: "Night", value: "NIGNT" },
                { label: "Morning", value: "MORNING" },
            ],
            leaveType: [
                { label: "Anual leave", value: "ANNUAL_LEAVE" },
                { label: "Special leave", value: "SPECIAL_LEAVE" },
                { label: "Sick leave", value: "SICK_LEAVE" },
                { label: "Maternity leave", value: "MATERNITY_LEAVE" },
                { label: "Mandatory leave", value: "MANDATORY_LEAVE" },
                { label: "Marriage leave", value: "MARRIAGE_LEAVE" },
                {
                    label: "Compensate leave",
                    value: "COMPENSATE_LEAVE",
                },
            ],
            form: {
                leaveStartDate: new Date(),
                leaveEndDate: new Date(),
                leaveReason: "",
                leaveOption: "",
                leaveType: "",
                valid: false,
                compensateDate: new Date(),
                relief_id: "",
            },
        };
    },
    watch: {
        "form.leaveType"(item) {
            if (item === "COMPENSATE_LEAVE") {
                this.isCompensated = true;
                return;
            }
        },
        async search(newSearch) {
            if (newSearch.length >= 2) {
                await this.fetchData(newSearch);
            }
        },
    },
    computed: {
        ...mapGetters("Leave", ["searchEmployees"]),
        filterItems() {
            return this.searchEmployees.map((item) => ({
                text: item.firstName + " " + item.lastName,
                value: item.id,
            }));
        },
    },
    methods: {
        ...mapActions("Leave", ["searchEmployee"]),
        async fetchData() {
            if (this.search.length > 2) {
                try {
                    this.loading = true;
                    this.items = await this.searchEmployee(this.search);
                } catch (e) {
                } finally {
                    this.loading = false;
                }
            }
        },
        async submitForm() {
            try {
                // Perform form submission logic here
                console.log(
                    "Form submitted successfully",
                    this.form,
                    this.search
                );
            } catch (error) {
                console.error("Error submitting form:", error);
            }
        },
        required(v) {
            return !!v || "Field is required";
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
