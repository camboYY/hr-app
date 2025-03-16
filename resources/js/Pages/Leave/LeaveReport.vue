<template>
    <div class="mx-auto">
        <v-row>
            <v-col cols="12">
                <v-card>
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
                        <v-data-table
                            :no-data-text="noDataAvailable"
                            :headers="headers"
                            :items="leavesData"
                            item-key="id"
                            class="elevation-1"
                            v-model:items-per-page="leaves.per_page"
                            @update:page="getEmployees"
                            :items-length="leaves.total"
                            :loading="loading"
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
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
    data: () => ({
        loading: false,
        noDataAvailable: "",
        headers: [
            {
                title: "Staff Name",
                sortable: true,
                key: "staffName",
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
                sortable: true,
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
    async mounted() {
        await this.fetchLeaves();
    },
    computed: {
        ...mapGetters("Leave", ["leaves"]),
        leavesData() {
            if (this.leaves?.data?.length === 0) {
                this.noDataAvailable = "No record found";
            }
            console.log("Leaves: " + this.leaves);
            return this.leaves?.data?.map((item) => {
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
        ...mapActions("Leave", ["fetchLeaves"]),
    },
};
</script>

<style lang="scss" scoped></style>
