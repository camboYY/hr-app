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
                            debounce="300"
                        ></v-date-input>
                        <v-date-input
                            v-model="toDate"
                            label="End date"
                            debounce="300"
                        ></v-date-input>
                    </div>
                    <div class="d-flex flex-row flex-wrap">
                        <v-btn
                            color="green"
                            v-if="leavePendingApproval?.data?.length > 0"
                            @click="checkPendingApproval"
                        >
                            Leave Pending Approval
                            <v-badge
                                color="white"
                                :content="leavePendingApproval?.data?.length"
                            >
                            </v-badge>
                        </v-btn>
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
                            :items="leavesData.items"
                            class="elevation-1"
                            :loading="loading"
                            v-model:items-per-page="itemsPerPage"
                            :items-length="leaves?.total"
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
                                    v-show="item.leaveStatus === 'PENDING'"
                                    small
                                    class="mr-2"
                                    @click="handleEdit(item)"
                                >
                                    mdi-cancel
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
        page: 0,
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
                title: "Leave Option",
                value: "leaveOption",
                sortable: false,
                align: "start",
            },
            {
                title: "Actions",
                value: "actions",
                sortable: false,
            },
        ],
    }),
    async created() {
        await this.fetctPendingLeaveApproval();
    },
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
        ...mapGetters("Leave", ["leaves", "leavePendingApproval"]),
        leavesData() {
            if (this.leaves?.data?.length === 0) {
                this.noDataAvailable = "No record found";
            }
            const items = this.leaves?.data?.map((leave, i) => ({
                ...leave,
                leaveStatus: leave?.status,
                leaveType: leave?.leave_type,
                leaveBalance: leave?.leave_balance,
                leaveOption: leave?.leave_option,
            }));

            return { items };
        },
    },
    methods: {
        ...mapActions("Leave", [
            "fetchLeaves",
            "cancelLeave",
            "fetctPendingLeaveApproval",
        ]),
        checkPendingApproval() {
            this.$router.push({
                name: "leave.pending-approval",
            });
        },
        formatDate(newDate) {
            return moment(newDate).format("Y-MM-DD");
        },
        async handleEdit(item) {
            await this.cancelLeave({
                id: item.id,
                leave_status: "CANCELLED",
            });
            await this.fetchLeaves({
                page: this.page,
                perPage: this.itemsPerPage,
                search: this.search,
                fromDate: this.formatDate(this.fromDate ?? new Date()),
                toDate: this.formatDate(this.toDate ?? new Date()),
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
