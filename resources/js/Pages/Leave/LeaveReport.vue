<template>
    <div class="mx-auto">
        <v-row>
            <v-col cols="12">
                <v-card>
                    <div class="d-flex flex-row flex-wrap">
                        <!-- Search Field -->
                        <v-text-field
                            v-model="search"
                            label="Search Staff Name..."
                            debounce="600"
                        ></v-text-field>
                        <v-date-input
                            v-model="fromDate"
                            label="Start date"
                            @input="fetchLeaves"
                            debounce="300"
                        ></v-date-input>
                        <v-date-input
                            v-model="toDate"
                            label="End date"
                            @input="fetchLeaves"
                            debounce="300"
                        ></v-date-input>
                    </div>
                    <v-card-title>
                        <v-row>
                            <v-col cols="6">
                                <span class="title">Leave Request List</span>
                            </v-col>
                            <v-col cols="6" class="text-right">
                                <v-btn
                                    color="primary"
                                    @click="
                                        () =>
                                            $router.push({
                                                name: 'leave.request',
                                            })
                                    "
                                >
                                    Request leave
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table-server
                            :no-data-text="noDataAvailable"
                            :headers="headers"
                            :items="leavesData"
                            class="elevation-1"
                            :loading="loading"
                            v-model:items-per-page="itemsPerPage"
                            :items-length="leaves.total"
                            @update:options="fetchLeaves"
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
    </div>
</template>

<script>
import moment from "moment";
import { VDateInput } from "vuetify/labs/VDateInput";
import { mapActions, mapGetters } from "vuex";

export default {
    components: { VDateInput },
    data: () => ({
        loading: false,
        noDataAvailable: "",
        page: 1,
        search: "",
        itemsPerPage: 10,
        fromDate: null,
        toDate: null,
        headers: [
            {
                title: "Staff Name",
                sortable: true,
                key: "staffName",
            },
            {
                title: "Relief Name",
                key: "reliefName",
                sortable: true,
                align: "start",
            },
            {
                title: "Reason",
                key: "reason",
                sortable: true,
                align: "reason",
            },
            {
                title: "Start Date",
                key: "fromDate",
                sortable: true,
                align: "start",
            },
            {
                title: "To Date",
                key: "toDate",
                sortable: true,
                align: "start",
            },
            {
                title: "Leave status",
                key: "leaveStatus",
                align: "start",
            },
            {
                title: "Leave Type",
                key: "leaveType",
                sortable: true,
                align: "start",
            },
            {
                title: "Leave Balance",
                key: "leaveBalance",
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

    watch: {
        fromDate(fromDate) {
            this.fetchLeaves({
                page: this.page,
                perPage: this.itemsPerPage,
                search: this.search,
                fromDate: this.formatDate(fromDate ?? new Date()),
                toDate: this.formatDate(this.toDate ?? new Date()),
            });
        },
        toDate(toDate) {
            this.fetchLeaves({
                page: this.page,
                perPage: this.itemsPerPage,
                search: this.search,
                fromDate: this.formatDate(this.fromDate ?? new Date()),
                toDate: this.formatDate(toDate ?? new Date()),
            });
        },
        search(search) {
            this.fetchLeaves({
                page: this.page,
                perPage: this.itemsPerPage,
                search,
                fromDate: this.formatDate(this.fromDate ?? new Date()),
                toDate: this.formatDate(this.toDate ?? new Date()),
            });
        },
    },
    computed: {
        ...mapGetters("Leave", ["leaves"]),
        leavesData() {
            if (this.leaves?.data?.length === 0) {
                this.noDataAvailable = "No record found";
            }
            return this.leaves?.data?.map((item) => {
                return {
                    ...item,
                    created_at: moment(item.created_at).format(
                        "MMMM Do YYYY, h:mm:ss a"
                    ),
                    staffName: !item?.employee
                        ? "-"
                        : item?.employee?.firstName +
                          " " +
                          item?.employee?.lastName,
                    leaveType: !item?.leave_type_setting
                        ? "-"
                        : item?.leave_type_setting?.leave_type,
                    leaveBalance: !item?.leave_type_setting
                        ? "-"
                        : item?.leave_type_setting?.leave_balance,
                    reliefName: !item?.relief
                        ? "-"
                        : item?.relief?.firstName +
                          " " +
                          item?.relief?.lastName,
                    leaveStatus: !!item?.leave_status
                        ? item?.leave_status?.status
                        : "OTHER",
                };
            });
        },
    },
    methods: {
        ...mapActions("Leave", ["fetchLeaves", "setLeave"]),
        formatDate(newDate) {
            return moment(newDate).format("Y-MM-DD");
        },
        handleEdit(item) {
            this.setLeave(item);
            this.$router.push({
                name: "leave.edit",
                params: { id: item.id },
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
