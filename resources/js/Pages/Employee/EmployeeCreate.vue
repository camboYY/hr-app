<template>
    <div>
        <v-container>
            <v-card class="mx-auto">
                <v-card-title>Create Employee </v-card-title>
                <v-form v-model="valid" @submit.prevent="onSubmit">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="form.firstName"
                                label="First name"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="form.lastName"
                                label="Last name"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="form.middleName"
                                label="Middle name"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-date-input
                                v-model="form.dateOfBirth"
                                label="Date of birth"
                                :rules="[required]"
                            ></v-date-input>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="form.phoneNumber"
                                label="Phone number"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-file-input
                                :rules="nationalIdRule"
                                accept="image/png, image/jpeg, image/bmp"
                                label="National ID"
                                placeholder="Pick an avatar"
                                v-model="form.nationalId"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-file-input
                                :rules="nationalIdRule"
                                accept="image/png, image/jpeg, image/bmp"
                                label="Medical certificate"
                                placeholder="Pick medical certificate"
                                v-model="form.medicalCertificate"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select
                                label="Marital status"
                                :items="['Single', 'Married', 'Divorced']"
                                :rules="[required]"
                                v-model="form.maritalStatus"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select
                                label="Gender"
                                :items="['Male', 'Female']"
                                :rules="[required]"
                                v-model="form.gender"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="form.currentAddress"
                                label="Current address"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4"
                            ><v-select
                                :items="designations"
                                v-model="form.designation_id"
                                label="Designation"
                                :rules="[required]"
                                item-title="name"
                                item-value="id"
                                counter
                                show-size
                            >
                            </v-select>
                        </v-col>
                        <v-col cols="12" md="4"
                            ><v-select
                                :items="departmentItems"
                                v-model="form.line_manager_id"
                                label="Department"
                                :rules="[required]"
                                item-title="name"
                                item-value="id"
                                counter
                                show-size
                            >
                            </v-select>
                        </v-col>
                        <v-col cols="12" md="4"
                            ><v-text-field
                                v-model="form.email"
                                label="Email"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4"
                            ><v-text-field
                                v-model="form.password"
                                label="Password"
                                :rules="[required]"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col class="center" cols="12">
                            <v-btn
                                :disabled="!valid"
                                :loading="loading"
                                color="primary"
                                type="submit"
                                variant="elevated"
                                >Save</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-form>
            </v-card>
        </v-container>
    </div>
</template>

<script>
import moment from "moment";
import Multiselect from "vue-multiselect";
import { VDateInput } from "vuetify/labs/VDateInput";

import { mapActions, mapGetters } from "vuex";
export default {
    components: {
        Multiselect,
        VDateInput,
    },
    setup() {
        const nationalIdRule = [
            (value) => {
                if (!value) return "Field is required";

                return (
                    !value ||
                    !value.length ||
                    value[0].size < 2000000 ||
                    "Avatar size should be less than 2 MB!"
                );
            },
        ];
        return { nationalIdRule };
    },
    data: () => ({
        form: {
            email: "",
            password: "",
            firstName: "",
            lastName: "",
            middleName: "",
            phoneNumber: "",
            nationalId: "",
            medicalCertificate: "",
            dateOfBirth: new Date(),
            currentAddress: "",
            maritalStatus: "",
            gender: "",
            line_manager_id: "",
            designation_id: "",
        },
        valid: false,
        loading: false,
    }),
    computed: {
        ...mapGetters("Designation", ["getDesignations"]),
        ...mapGetters("Department", ["departments"]),

        designations() {
            return this.getDesignations.data;
        },

        departmentItems() {
            return this.departments.data;
        },
    },
    methods: {
        ...mapActions("Designation", ["fetchDesignations"]),
        ...mapActions("Department", ["fetchDepartments"]),
        ...mapActions("Employee", ["createEmployee"]),

        async onSubmit() {
            this.loading = true;
            try {
                let form = new FormData();

                for (const [key, value] of Object.entries(this.form)) {
                    if (key === "dateOfBirth") {
                        form.append(key, moment(value).format("YYYY-MM-DD"));
                    } else {
                        form.append(key, value);
                    }
                }
                await this.createEmployee(form);
                this.$router.push({ name: "employee.list" });
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        required(v) {
            return !!v || "Field is required";
        },
    },
    mounted() {
        this.fetchDesignations();
        this.fetchDepartments();
    },
};
</script>

<style lang="scss" scoped>
.center {
    align-items: center;
    display: flex;
    justify-content: center;
}
.v-card {
    padding: 10px;
}
</style>
