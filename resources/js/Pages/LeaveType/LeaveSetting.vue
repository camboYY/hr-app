<template>
    <div>
        <v-container>
            <v-row>
                <v-col cols="12" md="6" offset-md="3">
                    <v-card>
                        <v-card-title>
                            <h2>Create Leave Type</h2>
                        </v-card-title>
                        <v-card-text>
                            <v-form class="flex" @submit.prevent="createLeave">
                                <v-text-field
                                    v-model="leaveType"
                                    :rules="leaveRules"
                                    label="Leave Type"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    v-model="leaveBalance"
                                    label="Leave Balance"
                                    :rules="leaveBalanceRules"
                                    type="number"
                                    required
                                ></v-text-field>
                                <v-btn
                                    :loading="loading"
                                    color="primary"
                                    type="submit"
                                >
                                    Save
                                </v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data: () => ({
        loading: false,
        leaveType: "",
        leaveBalance: 0,
        leaveRules: [
            (value) => {
                if (value) return true;

                return "Leave is required.";
            },
            (value) => {
                const regex = /^[a-zA-Z ]+$/;
                if (regex.test(value)) return true;

                return "Leave must alphabets only.";
            },
        ],
        leaveBalanceRules: [
            (value) => {
                if (value) return true;
                return "Leave balance is required.";
            },
        ],
    }),

    methods: {
        ...mapActions("Leave", ["createLeaveType"]),
        async createLeave() {
            try {
                this.loading = true;
                await this.createLeaveType({
                    name: this.leaveType,
                    description: this.leaveBalance,
                });
                this.$router.push({ name: "leaveType.list" });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.flex {
    display: flex;
    flex-direction: column;
    gap: 10px;
    button {
        height: 46px;
        width: 20%;
        margin: 0 auto;
    }
}
</style>
