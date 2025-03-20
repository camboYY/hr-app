<template>
    <div>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <v-row>
                            <v-col cols="6">
                                <span class="title">Employee List</span>
                            </v-col>
                            <v-col cols="6" class="text-right">
                                <v-btn
                                    color="primary"
                                    @click="
                                        () =>
                                            $router.push({
                                                name: 'employee.create',
                                            })
                                    "
                                >
                                    Add Employee
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table-server
                            :no-data-text="noDataAvailable"
                            :headers="headers"
                            :items="getManipulatedEmployees"
                            class="elevation-1"
                            :loading="loading"
                            v-model:items-per-page="itemsPerPage"
                            :items-length="employees.total"
                            @update:options="fetchEmployees"
                        >
                            <template v-slot:item.nationalId="{ value }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="showImage(value)"
                                >
                                    mdi-arrow-right-bold
                                </v-icon>
                            </template>
                            <template
                                v-slot:item.medicalCertificate="{ value }"
                            >
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="showImage(value)"
                                >
                                    mdi-arrow-right-bold
                                </v-icon>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="handleEdit(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon small @click="handleDelete(item.id)">
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table-server>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <ShowImage :source="image" :dialog="showImg" :onConfirm="onConfirm" />
    </div>
</template>

<script>
import ShowImage from "@/components/ShowImage.vue";
import moment from "moment";
import { mapActions, mapGetters } from "vuex";

export default {
    components: { ShowImage },
    data: () => ({
        image: "",
        showImg: false,
        loading: false,
        noDataAvailable: "",
        page: 1,
        itemsPerPage: 10,
        headers: [
            {
                title: "First Name",
                sortable: true,
                key: "firstName",
            },
            {
                title: "Last Name",
                key: "lastName",
                sortable: true,
                align: "start",
            },
            {
                title: "Middle Name",
                key: "middleName",
                sortable: true,
                align: "start",
            },
            {
                title: "Phone Number",
                key: "phoneNumber",
                sortable: true,
                align: "start",
            },
            {
                title: "Currrent Address",
                key: "currentAddress",
                sortable: true,
                align: "start",
            },
            {
                title: "National ID",
                key: "nationalId",
                sortable: true,
                align: "start",
            },
            {
                title: "Date of Birth",
                key: "dateOfBirth",
                sortable: true,
                align: "start",
            },
            {
                title: "Marital Status",
                key: "maritalStatus",
                sortable: true,
                align: "start",
            },
            {
                title: "Gender",
                key: "gender",
                sortable: true,
                align: "start",
            },
            {
                title: "Medical Certificate",
                key: "medicalCertificate",
                sortable: true,
                align: "start",
            },
            {
                title: "Actions",
                value: "actions",
                sortable: false,
            },
        ],
    }),

    computed: {
        ...mapGetters("Employee", ["employees"]),
        getManipulatedEmployees() {
            if (this.employees?.data?.length === 0) {
                this.noDataAvailable = "No record found";
            }
            return this.employees?.data?.map((item) => {
                return {
                    ...item,
                    created_at: moment(item.created_at).format(
                        "MMMM Do YYYY, h:mm:ss a"
                    ),
                };
            });
        },
    },
    methods: {
        ...mapActions("Employee", ["fetchEmployees", "deleteEmployee"]),
        showImage(imag) {
            this.image = imag;
            this.showImg = true;
        },
        async handleDelete(id) {
            await this.deleteEmployee(id);
        },
        onConfirm() {
            this.showImg = false;
        },
        async getEmployees() {
            this.loading = true;

            try {
                await this.fetchEmployees();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        handleEdit(item) {
            this.$router.push({
                name: "employee.edit",
                params: { id: item.id },
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
