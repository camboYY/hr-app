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
                            :items="filterItems"
                            label="Search relief"
                            chips
                            :rules="[required]"
                            :loading="loading"
                            item-title="text"
                            item-value="value"
                            v-model="form.relief_id"
                            @update:search="searchEmployee"
                        ></v-autocomplete>
                        <v-select
                            label="Leave Options"
                            :items="leaveOption"
                            item-title="label"
                            item-value="value"
                            v-model="form.leaveOption"
                            :rules="[required]"
                        >
                        </v-select>

                        <v-select
                            label="Leave Type"
                            :items="filterLeaveTypes"
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
                            :loading="loading"
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
import { formatDate } from "../../utils";

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
            loading: false,
            leaveOption: [
                { label: "Afternoon", value: "AFTERNOON" },
                { label: "Night", value: "NIGNT" },
                { label: "Morning", value: "MORNING" },
                { label: "Full Day", value: "FULL" },
            ],
            form: {
                leaveStartDate: new Date(),
                leaveEndDate: new Date(),
                leaveReason: "",
                leaveOption: "",
                leaveType: "",
                valid: false,
                relief_id: "",
            },
        };
    },
    watch: {
        async search(newSearch) {
            if (newSearch.length > 2) {
                await this.fetchData(newSearch);
            }
        },
    },
    async created() {
        await this.fetchLeaveTypes();
    },
    computed: {
        ...mapGetters("Leave", ["searchEmployees", "leaveTypes"]),
        filterItems() {
            return this.searchEmployees.map((item) => ({
                text: item.firstName + " " + item.lastName,
                value: item.id,
            }));
        },
        filterLeaveTypes() {
            return this.leaveTypes.map((item) => ({
                label: item.leave_type,
                value: item.id,
            }));
        },
    },
    methods: {
        ...mapActions("Leave", [
            "searchEmployee",
            "submitLeaveRequest",
            "fetchLeaveTypes",
        ]),
        async fetchData() {
            try {
                this.loading = true;
                this.items = await this.searchEmployee(this.search);
            } catch (e) {
            } finally {
                this.loading = false;
            }
        },

        async submitForm() {
            this.loading = true;
            try {
                // Perform form submission logic here
                await this.submitLeaveRequest({
                    leave_type_setting_id: this.form.leaveType,
                    relief_id: this.form.relief_id,
                    fromDate: formatDate(this.form.fromDate),
                    toDate: formatDate(this.form.toDate),
                    reason: this.form.leaveReason,
                    leave_option: this.form.leaveOption,
                });
                this.$router.push({ name: "leave.list" });
            } catch (error) {
                console.error("Error submitting form:", error);
            } finally {
                this.loading = false;
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
