<template>
    <v-card>
        <v-card-title>
            {{ title }}
        </v-card-title>
        <hr />
        <v-card-text>
            <v-data-table-server
                :no-data-text="noDataAvailable"
                :headers="headers"
                :items="leavesData"
                class="elevation-1"
                :loading="loading"
                v-model:items-per-page="itemsPerPage"
                :items-length="total"
                @update:options="fetchPendingLeaves"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn>
                        <v-tooltip activator="parent" location="start"
                            >Approve pending request</v-tooltip
                        >
                        <v-icon
                            v-show="item.leaveStatus === 'PENDING'"
                            small
                            class="mr-2"
                            @click="handleConfirmation(item)"
                        >
                            mdi-check
                        </v-icon>
                    </v-btn>
                </template>
            </v-data-table-server>
            <div class="d-flex">
                <v-btn @click="goToLeaveReport" color="primary"
                    >Back to leave report</v-btn
                >
            </div>
        </v-card-text>
        <Snackbar
            :message="snackbarMessage"
            :color="snackbarColor"
            :show="snackbarShow"
        />
        <ConfirmWithInput
            v-model:show="showDialog"
            @updateData="onReceiveMessage"
        />
    </v-card>
</template>

<script setup>
import ConfirmWithInput from "@/components/ConfirmWithInput.vue";
import Snackbar from "@/components/SnakBar.vue";
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
const route = useRouter();
const store = useStore();
const snackbarMessage = ref("");
const snackbarColor = ref("success");
const snackbarShow = ref(false);
const showDialog = ref(false);

const title = ref("Pending Leave Approval");
const leavesData = ref([]);
const total = ref(0);
const loading = ref(false);
const itemsPerPage = ref(10);
const noDataAvailable = ref();
const leaveData = ref({});

const headers = ref([
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
]);

const handleConfirmation = (item) => {
    showDialog.value = true;
    // Logic to approve the leave request
    leaveData.value = { leaveId: item.id, status: "APPROVED", comment: "" };
};

const onReceiveMessage = async (message) => {
    // Logic to approve the leave request
    try {
        await store.dispatch("Leave/approvePendingLeave", {
            ...leaveData.value,
            comment: message,
        });
        showSnackbar("Leave request approved successfully");
    } catch (error) {
        showSnackbar("Failed to approve leave request", "error");
    } finally {
        showDialog.value = false;
    }
};

const showSnackbar = (message, color = "success") => {
    snackbarMessage.value = message;
    snackbarColor.value = color;
    snackbarShow.value = true;

    setTimeout(() => {
        snackbarShow.value = false;
    }, 3000);
};

const goToLeaveReport = () => {
    route.push({ name: "leave.list" });
};

const leavePendingApproval = computed(
    () => store.getters["Leave/leavePendingApproval"]
);

const fetchPendingLeaves = computed(() => {
    if (leavePendingApproval?.value?.data?.length === 0) {
        noDataAvailable.value = "No record found";
    }
    const items = leavePendingApproval?.value?.data?.map((leave) => ({
        ...leave,
        leaveStatus: leave?.status,
        leaveType: leave?.leave_type,
        leaveBalance: leave?.leave_balance,
        leaveOption: leave?.leave_option,
    }));

    leavesData.value = items;
    total.value = leavePendingApproval.value?.total;
});
</script>

<style lang="scss" scoped></style>
